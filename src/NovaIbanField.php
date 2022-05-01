<?php

namespace Nembie\NovaIbanField;

use Exception;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaIbanField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-iban-field';

    /**
     * Show more details about IBAN.
     *
     * @return $this
    */
    public function showDetails()
    {
        return $this->withMeta(['showDetails' => true]);
    }

    /**
     * Set IBAN always "crypted" on index
     *
     * @return $this
    */
    public function alwaysHideOnIndex()
    {
        return $this->withMeta(['alwaysHideOnIndex' => true]);
    }

    /**
     * Hide actions on index(copy and show/hide)
     *
     * @return $this
    */
    public function hideActionsOnIndex()
    {
        return $this->withMeta(['hideActionsOnIndex' => true]);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    public function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if(!$this->validateIban($request[$requestAttribute])){
            throw new Exception(trans('messages::messages.iban_is_not_valid'));
        }else{
            if ($request->exists($requestAttribute)) {
                $model->{$attribute} = $request[$requestAttribute];
            }
        }
    }

    protected function validateIban($iban)
    {
        // Check if IBAN contains white space
        if(preg_match('/\s/',$iban))
            return false;
    
        // Check if IBAN contains special characters
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $iban))
            return false;
    
        // Get the rules by the country
        $path = substr(__DIR__, 0, -3).'resources/js/countries.json';
        $json = file_get_contents($path);
        $json = json_decode($json, true);
        $country = substr($iban, 0, 2);
        if(isset($json['sepa'][$country]))
            $countryObj = $json['sepa'][$country];
        else if(isset($json['not_sepa'][$country]))
            $countryObj = $json['not_sepa'][$country];
        else
            return false;

        // Get validation rules
        $rules = [];
        foreach ($countryObj as $attr)
            array_push($rules, $attr[1]);

        $tempIban = $iban;
        $hasError = false;
        $ibanLength = 0;
        foreach ($rules as $rule) {
            $numbers = intval(preg_replace('/[^0-9]/', '', $rule));
            $letter = preg_replace('/[^a-zA-Z]/', '', $rule);
            $checkString = substr($tempIban, 0, $numbers);
            $ibanLength = $ibanLength+$numbers;

            // Check if the string part is of the correct type
            if($letter === 'a' && !preg_match("/^[a-zA-Z]+$/", $checkString))
                $hasError = true;
            elseif($letter === 'n' && !preg_match("/^\d+$/", $checkString))
                $hasError = true;

            $tempIban = substr($tempIban, $numbers);
        }

        if($ibanLength != strlen($iban))
            $hasError = true;

        return !$hasError;
    }
}
