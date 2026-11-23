<?php
/**
 * Kontaktformular der von Kunhardt Akademie.
 *
 * Über das Finvision Child-Theme registrieren. Im Unyson-Textblock
 * [kunhardt_kontaktformular] im Code-Reiter einsetzen.
 */

add_shortcode( 'kunhardt_kontaktformular', static function () {
    $handle = 'kunhardt-kontaktformular';

    wp_register_style( $handle, false );
    wp_enqueue_style( $handle );
    wp_add_inline_style( $handle, <<<'KUNHARDT_CSS'
/* Das Formular steht auch im dunklen Startseiten-Abschnitt auf heller Fläche. */
.kontaktform_bg #vk-contact-form label,
.kontaktform_bg #vk-contact-form .theme_button,
.kontaktform_bg #vk-contact-form .vk-phone-prefix {
  color: #103045;
}
.kontaktform_bg #vk-contact-form label a {
  color: #103045;
  text-decoration: underline;
}

/* Vorwahl und Rufnummer teilen sich die Fläche eines Eingabefelds. */
.vk-phone-input {
  display: grid;
  grid-template-columns: minmax(0, 2fr) minmax(0, 3fr);
  align-items: stretch;
}
.vk-phone-input > .vk-phone-country,
.vk-phone-input > input.vk-phone-number {
  width: 100%;
  min-width: 0;
  margin: 0;
}
.vk-phone-input > .vk-phone-prefix { display: none; }

@supports selector(:has(*)) {
  .vk-phone-input { grid-template-columns: minmax(0, 108px) minmax(0, 1fr); }
  .vk-phone-input > .vk-phone-country {
    grid-area: 1 / 1;
    position: relative;
    z-index: 1;
    opacity: 0;
    cursor: pointer;
  }
  .vk-phone-input > input.vk-phone-number {
    grid-area: 1 / 1 / 2 / 3;
    padding-inline-start: 122px;
  }
  .vk-phone-input > .vk-phone-prefix {
    grid-area: 1 / 1;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    border-inline-end: 1px solid #cdd7df;
    color: inherit;
    background: inherit;
    font-size: inherit;
    font-weight: 600;
    line-height: 1;
    pointer-events: none;
  }
  .vk-phone-input > .vk-phone-country:focus-visible + .vk-phone-prefix {
    outline: 2px solid currentColor;
    outline-offset: -2px;
  }
  .vk-phone-prefix > span { display: inline-flex; align-items: center; gap: 6px; }
  .vk-phone-prefix > span::before {
    content: "";
    width: 1.2em;
    height: .8em;
  }
  .vk-phone-prefix > .vk-phone-de::before {
    background: linear-gradient(#000 33.33%, #d00 33.33% 66.67%, #ffce00 66.67%);
  }
  .vk-phone-prefix > .vk-phone-at::before {
    background: linear-gradient(#ed2939 33.33%, #fff 33.33% 66.67%, #ed2939 66.67%);
  }
  .vk-phone-prefix > .vk-phone-at,
  .vk-phone-input:has(option[value="+43"]:checked) .vk-phone-de { display: none; }
  .vk-phone-input:has(option[value="+43"]:checked) .vk-phone-at { display: inline-flex; }
  .vk-phone-prefix::after {
    content: "";
    border-inline: .25em solid transparent;
    border-top: .3em solid currentColor;
  }
}
KUNHARDT_CSS
    );

    wp_register_script( $handle, false, array(), false, true );
    wp_enqueue_script( $handle );
    wp_add_inline_script( $handle, <<<'KUNHARDT_JS'
(() => {
  const form = document.getElementById('vk-contact-form');
  const firstInterest = form.querySelector('input[name="Checkbox"]');
  const error = form.querySelector('#vk-interest-error');

  form.addEventListener('submit', (event) => {
    if (form.querySelector('input[name="Checkbox"]:checked')) return;
    event.preventDefault();
    error.hidden = false;
    firstInterest.setAttribute('aria-describedby', error.id);
    firstInterest.focus();
  });

  form.addEventListener('change', (event) => {
    if (event.target.name !== 'Checkbox' || !event.target.checked) return;
    error.hidden = true;
    firstInterest.removeAttribute('aria-describedby');
  });
})();

(() => {
  const phone = document.getElementById('vk-phone-number');
  if (!phone || !phone.form) return;

  const form = phone.form;
  const country = form.elements.namedItem('PhoneNumber_countrycodeval');

  const supportedPrefixes = Array.from(country.options, (option) => option.value);
  const phoneFormat = /^\+?[0-9\s().-]+$/;

  function splitPhone(value) {
    const compact = value.replace(/[\s().-]/g, '').replace(/^00/, '+');
    const prefix = supportedPrefixes.find((code) => compact.startsWith(code));
    return { prefix, number: prefix ? compact.slice(prefix.length) : compact };
  }

  phone.addEventListener('input', (event) => {
    phone.setCustomValidity('');
    const typed = phone.value.trim();
    if (event.isComposing || !phoneFormat.test(typed)) return;

    const { prefix, number } = splitPhone(typed);
    if (prefix) {
      country.value = prefix;
      phone.value = number;
    }
  });

  form.addEventListener('submit', (event) => {
    if (event.defaultPrevented) return;

    const typed = phone.value.trim();
    const { prefix, number } = splitPhone(typed);
    let message = '';

    if (!phoneFormat.test(typed)) {
      message = 'Bitte gib eine gültige Telefonnummer ein.';
    } else if (!prefix && number.startsWith('+')) {
      message = 'Bitte verwende eine Telefonnummer aus Deutschland (+49) oder Österreich (+43).';
    }

    // Bei DE und AT gehört die nationale Verkehrsausscheidungsziffer 0 nicht hinter die Ländervorwahl.
    const national = number.replace(/^0/, '');
    if (!message && !/^[0-9]{5,15}$/.test(national)) {
      message = 'Bitte gib nach der Ländervorwahl eine Telefonnummer mit 5 bis 15 Ziffern ein.';
    }

    if (message) {
      event.preventDefault();
      phone.setCustomValidity(message);
      phone.reportValidity();
      return;
    }

    if (prefix) country.value = prefix;
    phone.value = national;
  });
})();
KUNHARDT_JS
    );

    return <<<'KUNHARDT_HTML'
<form
  id="vk-contact-form"
  name="vk-contact-form"
  action="https://forms.zohopublic.eu/vonkunhardtakademie/form/IhreAnfrageandievonKunhardtAkademie/formperma/bAH4HVvQq-fsCsFJejZ1_NeENddr9qVVLLzgHK8dRO4/htmlRecords/submit"
  method="POST"
  enctype="multipart/form-data"
  accept-charset="UTF-8">
  <input type="hidden" name="zf_referrer_name" value="">
  <input type="hidden" name="zf_redirect_url" value="">
  <input type="hidden" name="zc_gad" value="">

  <p>Schreiben Sie uns, wir melden uns zeitnah persönlich bei Ihnen.</p>

  <div class="form-group">
    <label for="vk-anrede">Anrede *</label>
    <select id="vk-anrede" class="form-control select2-vk-native" name="Dropdown" autocomplete="honorific-prefix" required>
      <option value="">— auswählen —</option>
      <option value="Herr">Herr</option>
      <option value="Frau">Frau</option>
    </select>
  </div>

  <div class="row">
    <div class="form-group col-sm-6">
      <label for="vk-first-name">Vorname *</label>
      <input id="vk-first-name" class="form-control" type="text" name="Name_First" autocomplete="given-name" maxlength="255" placeholder="Vorname" required>
    </div>
    <div class="form-group col-sm-6">
      <label for="vk-last-name">Nachname *</label>
      <input id="vk-last-name" class="form-control" type="text" name="Name_Last" autocomplete="family-name" maxlength="255" placeholder="Nachname" required>
    </div>
  </div>

  <div class="form-group">
    <label for="vk-email">E-Mail-Adresse *</label>
    <input id="vk-email" class="form-control" type="email" name="Email" autocomplete="email" maxlength="255" placeholder="ihre@email.de" required>
  </div>

  <div class="form-group">
    <label for="vk-phone-number">Telefonnummer *</label>
    <div class="vk-phone-input">
      <select class="vk-phone-country select2-vk-native" name="PhoneNumber_countrycodeval" aria-label="Ländervorwahl" autocomplete="tel-country-code" required>
        <option value="+49" selected>🇩🇪 Deutschland +49</option>
        <option value="+43">🇦🇹 Österreich +43</option>
      </select>
      <span class="vk-phone-prefix" aria-hidden="true">
        <span class="vk-phone-de">+49</span>
        <span class="vk-phone-at">+43</span>
      </span>
      <input id="vk-phone-number" class="form-control vk-phone-number" type="tel" name="PhoneNumber_countrycode" autocomplete="tel-national" maxlength="40" placeholder="Telefonnummer" required>
    </div>
  </div>

  <fieldset class="form-group">
    <legend>Ich interessiere mich für * <small>(Mehrfachauswahl)</small></legend>
    <div class="row">
      <div class="col-sm-6">
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Ausbildung zum Business-Coach"> Ausbildung zum Business-Coach</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Ausbildung zum (Sport-)Mental-Coach"> Ausbildung zum (Sport-)Mental-Coach</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Speaker Skills / Rhetorik &amp; Bühnenpräsenz"> Speaker Skills / Rhetorik &amp; Bühnenpräsenz</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Mentoring (persönliche Begleitung)"> Mentoring (persönliche Begleitung)</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Buchmentoring (eigenes Buch schreiben)"> Buchmentoring (eigenes Buch schreiben)</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Masterclass Mentalgiganten"> Masterclass Mentalgiganten</label></div>
      </div>
      <div class="col-sm-6">
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Einzelcoaching / Persönliche Beratung"> Einzelcoaching / Persönliche Beratung</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Keynote / Vortrag für mein Event"> Keynote / Vortrag für mein Event</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Führungskräfte-Training (Unternehmen/Teams)"> Führungskräfte-Training (Unternehmen/Teams)</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Achtsamkeit &amp; Stressmanagement"> Achtsamkeit &amp; Stressmanagement</label></div>
        <div class="checkbox"><label><input type="checkbox" name="Checkbox" value="Noch unklar / allgemeine Beratung"> Noch unklar / allgemeine Beratung</label></div>
      </div>
    </div>
    <p id="vk-interest-error" class="text-danger" role="alert" hidden>Bitte mindestens ein Interesse wählen.</p>
  </fieldset>

  <div class="form-group">
    <label for="vk-msg">Ihre Nachricht (optional)</label>
    <textarea id="vk-msg" class="form-control" name="MultiLine" rows="5" maxlength="65535" placeholder="Ihr Anliegen, Ihre Frage oder eine kurze Vorstellung..."></textarea>
  </div>

  <div class="checkbox">
    <label for="vk-terms">
      <input id="vk-terms" type="checkbox" name="TermsConditions" required>
      Ich habe die <a href="https://www.vonkunhardt.de/datenschutz/" target="_blank" rel="noopener noreferrer">Datenschutzerklärung</a> gelesen und bin damit einverstanden, dass meine Angaben zur Bearbeitung meiner Anfrage gespeichert und verarbeitet werden. *
    </label>
  </div>

  <button class="theme_button color1" type="submit">Anfrage senden →</button>
</form>
KUNHARDT_HTML;
} );
