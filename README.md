# CUNY Tabs/Accordion WPBakery Element

This plugin adds an accessible, responsive tabs/accordion shortcode to WPBakery.

## Features
- WCAG-compliant markup and keyboard support
- Responsive switching between tabs (desktop) and accordion (mobile)
- Custom heading tag and section ID support

## Usage
1. Add the "Accessible Tabs/Accordion" element.
2. Inside it, add multiple "Accordion Sections".
3. Choose styles and behavior (collapse all, default open tab).

## Frontend Behavior
- On desktop (>992px): renders tabs layout (if Tads/Accordion checked) or accordion.
- On mobile (<=992px): renders accordion with expand/collapse.

## Accessibility
- Tab mode: arrow key nav, Home/End, full aria attributes.
- Accordion mode: up/down key navigation, enter/space toggle.
