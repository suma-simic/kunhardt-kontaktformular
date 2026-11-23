# Kontaktformular für vonkunhardt.de (Zoho Forms, gebrandet)

Auf der [Startseite](https://www.vonkunhardt.de/#vk-contact-form) und der
[Kontaktseite](https://www.vonkunhardt.de/contact/#vk-contact-form) steht im
Unyson-Textblock `[kunhardt_kontaktformular]`. Die produktive Registrierung
steht in der `functions.php` des Finvision-Child-Themes. Die Quelle liegt in
[`kunhardt-kontaktformular-shortcode.php`](kunhardt-kontaktformular-shortcode.php).
[`vonkunhardt-form-wordpress.html`](vonkunhardt-form-wordpress.html) ist die
entsprechende HTML-Vorschau. Das Formular nutzt Felder und Button des Finvision-Themes.
Das Telefonfeld bietet die 17 in Zoho Forms zugelassenen Länder und startet mit
Deutschland (+49). Beim Tippen oder Einfügen einer zugelassenen Nummer mit `+` oder
`00` wechselt die Flagge sofort. Das Skript übergibt Vorwahl und nationale Nummer
getrennt an Zoho Forms. Bei italienischen Festnetznummern bleibt die führende Null
erhalten. [Flaggen](https://flagpedia.net/download)

Der Shortcode lädt CSS und JavaScript über das Child-Theme. Die Formularhöhe
folgt dem Inhalt, auch wenn eine Fehlermeldung erscheint. Nach Änderungen am
Shortcode die Seitencaches für Start- und Kontaktseite leeren und beide Seiten
auf Desktop und Smartphone prüfen.

---

## Die Dateien

| Datei | Zweck |
|-------|-------|
| `kunhardt-kontaktformular-shortcode.php` | Produktive Shortcode-Quelle für Finvision Child. |
| `vonkunhardt-form-wordpress.html` | Selbständige Variante für Vorschautests mit Finvision. |
| `vonkunhardt-form.css` | Nur das CSS. Kommt in den WordPress-Customizer („Zusätzliches CSS"). |
| `vonkunhardt-form-block.html` | HTML + JavaScript ohne `<style>`. Kommt in einen Custom-HTML-Block auf der Seite. Gehört zu `vonkunhardt-form.css`. |
| `vonkunhardt-form-embed.html` | Alles-in-einem-Variante (CSS + HTML + JS in einer Datei). Alternative, falls Weg A nicht gewünscht ist. |

Es wird **kein Plugin** benötigt. Das Formular postet direkt an Zoho Forms (EU-Server),
WordPress muss nichts verarbeiten. Contact Form 7 bleibt unberührt und wird nicht verwendet.

---

## Eigenständige Gestaltung — Weg A

1. **CSS hinterlegen:** Kompletten Inhalt von `vonkunhardt-form.css` kopieren und unter
   **Design → Customizer → Zusätzliches CSS** einfügen, speichern/veröffentlichen.
2. **Formular einfügen:** Kompletten Inhalt von `vonkunhardt-form-block.html` in einen
   **Gutenberg „Custom HTML"-Block** (oder ein **Elementor „HTML"-Widget**) auf der
   Zielseite einfügen, Seite aktualisieren.

Fertig. Das CSS ist über den Wrapper `.vk-form` gescopt und beeinflusst nichts anderes
auf der Seite.

## Eigenständige Gestaltung — Weg B

Kompletten Inhalt von `vonkunhardt-form-embed.html` in einen **Gutenberg „Custom
HTML"-Block** oder ein **Elementor „HTML"-Widget** einfügen. Kein Customizer-Schritt nötig.

---

## Wichtige Hinweise

### Hinweis zu `<style>` und `<script>`
Nur der Vollständigkeit halber: Je nach Editor und Konfiguration kann es vorkommen, dass
WordPress `<style>`- und `<script>`-Blöcke beim Speichern herausfiltert. Sollte das
Formular also ungestylt erscheinen oder die Interesse-Validierung nicht greifen, wäre das
die naheliegendste Ursache. Ein Custom-HTML-Block (Gutenberg), ein Elementor-HTML-Widget
oder ein Code-Snippet-Plugin sind hier erfahrungsgemäß unkritisch — du kennst die Instanz
am besten und wählst den Weg, der in eurem Setup üblich ist.

### Google Fonts (nur Weg B relevant)
Die erste Zeile in `vonkunhardt-form-embed.html` lädt Montserrat + Playfair Display von
`fonts.googleapis.com`. Da das Theme (finvision) diese Fonts bereits nutzt, kann diese
Zeile in der Regel **ersatzlos gelöscht** werden — das ist wegen DSGVO (Google-Fonts-
Remote-Einbindung) auch die sauberere Variante. Bei Weg A steht der Font-Import oben in der CSS-Datei und kann für die Website entfallen.

### Borlabs Cookie
Kein Handlungsbedarf. Das Formular ist **kein iFrame**, sondern direkt eingebettetes
HTML — Borlabs blockt hier nichts, es braucht keine Consent-Ausnahme.

### JavaScript-Validierung
Das kleine Script am Ende prüft, dass mindestens ein „Interesse" angehakt ist. Alle
anderen Pflichtfelder laufen über natives HTML5 `required`. Falls der verwendete Block
`<script>` filtert: Script separat über ein Code-Snippet-Plugin einbinden.

### Weiterleitung nach dem Absenden

Zoho Forms leitet nach erfolgreichem Absenden zur Dankeseite der Akademie weiter.
Die URL steht im Formular unter **Einstellungen → Dankseite und Weiterleitung**.
[Dankeseite](https://www.vonkunhardt.de/danke-fuer-ihre-anfrage/)

### Bitte nichts an den Feld-Namen ändern
Die `name`-Attribute (`Dropdown`, `Name_First`, `Email`, `Checkbox`, …) und die
`action`-URL sind exakt auf das Zoho-Formular gemappt. Texte/Labels dürfen nach
Absprache angepasst werden, die technischen Attribute nicht.

---

## Checkliste nach dem Einbau

- [ ] In der Desktop-Vorschau prüfen, ob Felder und Button wie im Website-Theme aussehen.
- [ ] Seite auf dem Smartphone ansehen: einspaltig, Interesse-Liste untereinander
- [ ] Die Länderwahl prüfen und eine Schweizer Nummer mit `0041` einfügen. Vorwahl, Flagge und Rufnummer in den Formulardaten prüfen. Bei einer italienischen Festnetznummer die führende Null prüfen.
- [ ] Absenden ohne Eingaben → Browser meldet Pflichtfelder an
- [ ] Alles ausfüllen, aber kein Interesse anhaken → rote Meldung an der Interesse-Box
- [ ] **Kein Test-Absenden nötig** — den finalen Funktionstest bis ins CRM machen wir
      selbst. Bitte einfach kurz Bescheid geben, sobald das Formular live ist.

---

## Kontakt

Marko Simic — SuMa SIMIC Consulting LTD
m.simic@suma-consulting.com

Bei Fragen zum Einbau oder wenn etwas anders aussieht als in der Vorschau: einfach melden.
