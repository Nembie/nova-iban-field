export function validateIban(iban) {
    // Check if IBAN contains white space
    if(/\s/.test(iban))
        return false;
    
    // Check if IBAN contains special characters
    const specialCharacters = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    if(specialCharacters.test(iban))
        return false;

    // Get the rules by the country
    let json = require('./countries.json');
    const country = iban.substr(0,2);
    let countryObj = null;

    // Check if IBAN is SEPA, NOT SEPA or invalid
    if(json.sepa[country])
        countryObj = json.sepa[country];
    else if(json.not_sepa[country])
        countryObj = json.not_sepa[country];
    else
        return false;

    // Get validation rules
    let rules = [];
    Object.keys(countryObj).forEach(function(key){
        rules.push(countryObj[key][1]);
    });

    let tempIban = iban;
    let hasError = false;
    let ibanLength = 0;
    rules.forEach(element => {
        const [digits, word] = element.match(/\D+|\d+/g);
        let checkString = tempIban.substr(0, digits);
        ibanLength = ibanLength + parseInt(digits);

        // Check if the string part is of the correct type
        if(word === 'a' && !/^[a-zA-Z]+$/.test(checkString))
            hasError = true;
        else if(word === 'n' && !/^\d+$/.test(checkString))
            hasError = true;

        tempIban = tempIban.substr(digits);
    });

    if(iban.length != ibanLength)
        hasError = true;

    return !hasError;
}