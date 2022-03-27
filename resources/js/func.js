import { COUNTRIES, CHARS } from './const';

export function validateIban(iban) {
    iban = iban.trim().toLowerCase();
    if(COUNTRIES[iban.substr(0,2)] == iban.length){
        const movedChar = iban.substr(4)+iban.substr(0,4);
        const movedCharArray = movedChar.split("");
        let string = "";
        movedCharArray.forEach((v, k) => {
            if(isNaN(movedCharArray[k])){
                movedCharArray[k] = CHARS[movedCharArray[k]];
            }
            string = string+movedCharArray[k];
        });

        return (string/97) >= 1;
    }

    return false;
}