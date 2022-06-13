<h2 align="center">
    🏦 Laravel Nova IBAN Field
</h2>

<p align="center">
  <strong>A simple field for <a href="https://nova.laravel.com/">Laravel Nova</a> that validates IBANs.</strong>
</p>

<p align="center">
  <a href="https://github.com/Nembie/nova-iban-field/blob/master/LICENSE">
    <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Released under the MIT license." />
  </a>
  <a href="https://github.com/Nembie/nova-iban-field/pulls">
    <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs welcome!" />
  </a>
  <a href="https://packagist.org/packages/nembie/nova-iban-field">
    <img src="https://img.shields.io/packagist/v/nembie/nova-iban-field" alt="Packagist Version">
  </a>
</p>

<img src="https://github.com/Nembie/nova-iban-field/blob/master/nova-iban-field.gif" alt="Test case" />

## ⚙️ Installation

```composer require nembie/nova-iban-field```

## 🛠️ Usage

```
use Nembie\NovaIbanField\NovaIbanField;

...

public function fields(Request $request)
{
    return [
    
        NovaIbanField::make(__('Custom IBAN Label'), 'iban_column')->showDetails()
          
    ];
}
```

## 🧰 Methods

- `showDetails()` - shows the information given by IBAN on the resource detail page
- `hideActionsOnIndex()` - hide the actions on the index (copy and show/hide)
- `alwaysHideOnIndex()` - "crypt" the IBAN in the index page

## 🌍 Supported countries

[Full list of supported countries](https://github.com/Nembie/nova-iban-field/blob/master/COUNTRIES.md)


## 🗒️ Note

* This field only checks the formatting of the string, there is no check that the iban is actually valid and working.
* German translation was done via google translate, it's probably wrong.
  