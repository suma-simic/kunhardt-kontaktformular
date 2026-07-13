# Kontaktformular für vonkunhardt.de (Zoho Forms, gebrandet)

Fertig gestyltes Kontaktformular für die von Kunhardt Akademie, das direkt an Zoho Forms
sendet und im CRM automatisch Kontakt + Anfrage + Verkaufschance anlegt. Das Formular ist
komplett fertig gebaut und getestet — es muss nur noch in die WordPress-Seite eingebaut werden.

**Live-Vorschau (so soll es am Ende aussehen):**
https://kunhardt-kontaktformular-test.netlify.app

**Zielseite:** https://www.vonkunhardt.de/contact/ — dort soll das Formular eingebunden
werden. Darüber hinaus kann es überall dort eingesetzt werden, wo es thematisch passt
oder als Call-to-Action sinnvoll ist (z.B. auf Angebots- oder Landingpages) — das CSS
ist über den Wrapper gescopt und kommt sich mit dem restlichen Seiten-Styling nicht
in die Quere.

---

## Die Dateien

| Datei | Zweck |
|-------|-------|
| `vonkunhardt-form.css` | Nur das CSS. Kommt in den WordPress-Customizer („Zusätzliches CSS"). |
| `vonkunhardt-form-block.html` | HTML + JavaScript ohne `<style>`. Kommt in einen Custom-HTML-Block auf der Seite. Gehört zu `vonkunhardt-form.css`. |
| `vonkunhardt-form-embed.html` | Alles-in-einem-Variante (CSS + HTML + JS in einer Datei). Alternative, falls Weg A nicht gewünscht ist. |

Es wird **kein Plugin** benötigt. Das Formular postet direkt an Zoho Forms (EU-Server),
WordPress muss nichts verarbeiten. Contact Form 7 bleibt unberührt und wird nicht verwendet.

---

## Einbau — Weg A (empfohlen, robust)

1. **CSS hinterlegen:** Kompletten Inhalt von `vonkunhardt-form.css` kopieren und unter
   **Design → Customizer → Zusätzliches CSS** einfügen, speichern/veröffentlichen.
2. **Formular einfügen:** Kompletten Inhalt von `vonkunhardt-form-block.html` in einen
   **Gutenberg „Custom HTML"-Block** (oder ein **Elementor „HTML"-Widget**) auf der
   Zielseite einfügen, Seite aktualisieren.

Fertig. Das CSS ist über den Wrapper `.vk-form` gescopt und beeinflusst nichts anderes
auf der Seite.

## Einbau — Weg B (Alternative, alles in einem Block)

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
Remote-Einbindung) auch die sauberere Variante. Bei Weg A gibt es keinen Font-Load,
dort greifen automatisch die Theme-Fonts.

### Borlabs Cookie
Kein Handlungsbedarf. Das Formular ist **kein iFrame**, sondern direkt eingebettetes
HTML — Borlabs blockt hier nichts, es braucht keine Consent-Ausnahme.

### JavaScript-Validierung
Das kleine Script am Ende prüft, dass mindestens ein „Interesse" angehakt ist. Alle
anderen Pflichtfelder laufen über natives HTML5 `required`. Falls der verwendete Block
`<script>` filtert: Script separat über ein Code-Snippet-Plugin einbinden.

### Weiterleitung nach dem Absenden (optional)
Aktuell zeigt Zoho nach dem Absenden seine Standard-Bestätigungsseite. Soll stattdessen
auf eine Danke-Seite der Website weitergeleitet werden, die gewünschte URL in das
Hidden-Feld `zf_redirect_url` eintragen (steht im HTML direkt nach dem `<form>`-Tag).
Bitte vorher kurz mit uns abstimmen.

### Bitte nichts an den Feld-Namen ändern
Die `name`-Attribute (`Dropdown`, `Name_First`, `Email`, `Checkbox`, …) und die
`action`-URL sind exakt auf das Zoho-Formular gemappt. Texte/Labels dürfen nach
Absprache angepasst werden, die technischen Attribute nicht.

---

## Checkliste nach dem Einbau

- [ ] Seite auf Desktop ansehen: Formular sieht aus wie die Live-Vorschau (Karte mit
      Schatten, Navy-Überschrift, türkise Akzente, Button mit Hover-Rahmen-Effekt)
- [ ] Seite auf dem Smartphone ansehen: einspaltig, Interesse-Liste untereinander
- [ ] Absenden ohne Eingaben → Browser meldet Pflichtfelder an
- [ ] Alles ausfüllen, aber kein Interesse anhaken → rote Meldung an der Interesse-Box
- [ ] **Kein Test-Absenden nötig** — den finalen Funktionstest bis ins CRM machen wir
      selbst. Bitte einfach kurz Bescheid geben, sobald das Formular live ist.

---

## Kontakt

Marko Simic — SuMa SIMIC Consulting LTD
m.simic@suma-consulting.com

Bei Fragen zum Einbau oder wenn etwas anders aussieht als in der Vorschau: einfach melden.
