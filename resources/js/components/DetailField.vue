<template>
    <div class="flex border-b border-40">
        <div class="w-1/4 py-4">
            <slot>
                <h4 class="font-normal text-80 mb-4">
                    {{ field.name }}
                </h4>
                <h4 class="font-normal text-80 mb-4" v-if="field.showDetails">
                    {{ __('sepa') }}
                </h4>
                <h4 class="font-normal text-80 mb-4" v-if="countryName && field.showDetails">
                    {{ __('country') }}
                </h4>
            </slot>
        </div>
        <div class="w-3/4 py-4">
            <p class="text-90 mb-4"> {{ field.value }}</p>
            <p class="text-90 mb-4" v-if="field.showDetails"> {{ this.isSepa ? '✔' : '✖'}}</p>
            <p class="text-90 mb-4" v-if="this.countryName && field.showDetails">{{__(this.countryName)}}</p>
            <p class="text-90 mb-4" v-if="this.bankCode && field.showDetails">{{this.bankCode}}</p>
        </div>
    </div>
</template>

<script>
import { SEPA_COUNTRIES } from '../const';
import { COUNTRIES_NAME } from '../countries';

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    data: function() {
		return {
			isSepa: false,
            countryName: null,
            bankCode: null
		}
	},
    mounted() {
        const countryCode = this.field.value.substr(0,2);
        this.isSepa = SEPA_COUNTRIES.includes(countryCode);
        const country = COUNTRIES_NAME.find(o => o.code === countryCode);
        if(country)
            this.countryName = country.name;
    }
}
</script>
