function formValidate(form, func) {
    var i;
    var fields = form.elements;
    var l = fields.length;
    var valid = false;

    for (i = 0; i < l; i++) {
        valid = fieldValidate(fields[i]);
        if (!valid) {
            return false;
        }
    }

    if (func != null) {
        return eval(func);
    } else {
        return true;
    }
}

/*==================================================

FUNZIONE: fieldValidate()

DESCRIZIONE:
Convalida un campo di una form in base alla presenza dei seguenti attributi
pseudo-HTML:

	ddv-maxlength	Indica il numero massimo di caratteri consentito
	ddv-minlength	Indica il minimo numero di caratteri previsto
	ddv-required	Indica se un campo � obbligatorio (true) o meno (false)
	ddv-type		Indica il tipo di dato previsto per il campo (numeric, date)
	ddv-regexp		Indica l'espressione regolare in base a cui il campo si considera valido

	ddv-dateformat	Indica il formato della data da considerare valido (en/it - valore predefinito = en)
			L'attributo � preso in considerazione soltanto in combinazione con ddv-type="date"

Nel caso in cui sia specificato il secondo parametro, viene valutata
l'espressione dopo aver validato il campo

INPUT:
field =	l'oggetto che rappresenta il campo da validare
func = 	espressione di tipo stringa che rappresenta l'eventuale 
	espressione aggiuntiva da valutare al termine della validazione;
	questo parametro � opzionale
	
OUTPUT:
La funzione restituisce un valore booleano; � responsabilit� dell programmatore
fare in modo che l'eventuale espressione aggiuntiva sia di tipo booleano

==================================================*/

function fieldValidate(field, func) {
    //ddv-maxlength
    if (field.attributes["ddv-maxlength"] != null) {
        if (field.value.length > field.attributes["ddv-maxlength"].value) {
            alert(
                "Le dimensioni del campo non possono superare " +
                    field.attributes["ddv-maxlength"].value +
                    " caratteri!"
            );
            field.focus();
            return false;
        }
    }

    //ddv-minlength
    if (field.attributes["ddv-minlength"] != null) {
        if (
            field.value.length < field.attributes["ddv-minlength"].value &&
            field.value.length != 0
        ) {
            alert(
                "Le dimensioni del campo devono essere di almeno " +
                    field.attributes["ddv-minlength"].value +
                    " caratteri!"
            );
            field.focus();
            return false;
        }
    }

    //ddv-required
    if (field.attributes["ddv-required"] != null) {
        if (field.attributes["ddv-required"].value && isBlank(field.value)) {
            alert("L'inserimento di un valore nel campo � obbligatorio!");
            field.focus();
            return false;
        }
    }

    //ddv-type
    if (field.attributes["ddv-type"] != null) {
        //Numeric data type validation
        if (
            field.attributes["ddv-type"].value.toLowerCase() == "numeric" &&
            isNaN(field.value)
        ) {
            alert("Il campo prevede un valore numerico!");
            field.focus();
            return false;
        }

        //Date data type validation
        if (field.attributes["ddv-type"].value.toLowerCase() == "date") {
            var DateFormat = "en";

            if (field.attributes["ddv-dateformat"] != null) {
                DateFormat =
                    field.attributes["ddv-dateformat"].value.toLowerCase();
            }

            if (!verifyDateFormat(field.value, DateFormat)) {
                alert("Il campo prevede una valore di tipo data!");
                field.focus();
                return false;
            }
        }
    }

    //ddv-regexp
    if (field.attributes["ddv-regexp"] != null) {
        var re = new RegExp("^" + field.attributes["ddv-regexp"].value + "$");

        if (field.value.match(re) == null) {
            alert("Il valore inserito non rispetta il formato previsto!");
            field.focus();
            return false;
        }
    }

    if (func != null) {
        return eval(func);
    } else {
        return true;
    }
}

/*==================================================

FUNZIONE: verifyDateFormat()

DESCRIZIONE:
Verifica la validit� di una data in base al formato specificato.

INPUT:
DateString =	stringa che rappresenta la data da verificare
Format = 	stringa che rappresenta il formato della data in base al quale verificarla;
		sono previsti due formati:
			en	formato inglese (mm/gg/aaaa)
			it	formato italiano (gg/mm/aaaa)

OUTPUT:
La funzione restituisce true se la data � valida; false altrimenti.

==================================================*/

function verifyDateFormat(DateString, DateFormat) {
    var match;
    var tmpDate;
    var validFormat = false;

    try {
        match = DateString.match(/^(\d?\d)\D(\d?\d)\D(\d{4}|\d{2})$/);

        if (match != null) {
            if (DateFormat == "en") {
                tmpDate = new Date(match[3], match[1] - 1, match[2]);
                validFormat =
                    tmpDate.getMonth() == match[1] - 1 &&
                    tmpDate.getDate() == match[2];
            } else {
                tmpDate = new Date(match[3], match[2] - 1, match[1]);
                validFormat =
                    tmpDate.getMonth() == match[2] - 1 &&
                    tmpDate.getDate() == match[1];
            }
        }
    } catch (e) {
        alert(e.message);
    } finally {
        return validFormat;
    }
}

/*==================================================

FUNZIONE: setConstraint()

DESCRIZIONE:
Imposta dinamicamente un attributo di validazione.

INPUT:
element =	stringa che indica l'ID dell'elemento
		a cui applicare il vincolo di validazione
		
attribute = 	stringa che indica il nome dell'attributo pseudo-HTML
		da impostare
		
value = 	stringa che indica il valore da assegnare all'attributo
		pseudo-HTML specificato nel parametro attribute

==================================================*/

function setConstraint(element, attribute, value) {
    var elem;
    var attr;

    elem = document.getElementById(element);

    if (elem != null) {
        attr = document.createAttribute(attribute);
        attr.value = value;
        elem.setAttributeNode(attr);
    }
}

function isBlank(cArg) {
    while (cArg.length > 0 && cArg.charAt(cArg.length - 1) == " ") {
        cArg = cArg.substring(0, cArg.length - 1);
    }
    return cArg == "";
}
