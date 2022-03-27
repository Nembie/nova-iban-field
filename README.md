<h2 align="center">
    🏦 Laravel Nova IBAN Field
</h2>

<p align="center">
  <strong>A simple field for Laravel Nova that validates the inserted IBANs.</strong>
</p>

<p align="center">
  <a href="https://github.com/Nembie/nova-iban-field/blob/master/LICENSE">
    <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Released under the MIT license." />
  </a>
  <a href="https://github.com/Nembie/nova-iban-field/pulls">
    <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs welcome!" />
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
    
        NovaIbanField::make(__('IBAN'), 'iban'),
        
    ];
}
```


## <h4>💡 Future ideas/implementations:</h4>
* Block the submit in case the IBAN is not valid
* Show the details provided by IBAN
* Improve error handling
* Add multiple languages ​​for validation