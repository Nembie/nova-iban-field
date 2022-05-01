<template>
    <div class="flex border-b border-40">
        <div class="w-1/4 py-4">
            <slot>
                <h4 class="font-normal text-80 mb-4">
                    {{ field.name }}
                </h4>
                <h4 class="font-normal text-80 mb-4" v-if="field.showDetails && Object.keys(info).length > 0">
                    {{ __('sepa') }}
                </h4>
                <h4 class="font-normal text-80 mb-4" v-for="(item, index) in info" v-bind:key="index">
                    {{__(index)}}
                </h4>
            </slot>
        </div>
        <div class="w-3/4 py-4">
            <p class="text-90 mb-4"> {{ field.value }}</p>
            <p class="text-90 mb-4" v-if="field.showDetails && Object.keys(info).length > 0"> {{ this.isSepa ? '✔' : '✖'}}</p>
            <p class="text-90 mb-4" v-for="(item, index)  in info" v-bind:key="index">
                {{__(item)}}
            </p>
        </div>
    </div>
</template>

<script>

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    data: function() {
		return {
			isSepa: false,
            info: {}
		}
	},
    mounted() {
        if(!this.field.showDetails)
            return;

        let countries = require('./../countries.json');
        const countryCode = this.field.value.substr(0,2);

        let countryObj = null;
        if(countries.sepa[countryCode]){
            this.isSepa = true;
            countryObj = countries.sepa[countryCode];
        }else if(countries.not_sepa[countryCode]){
            countryObj = countries.not_sepa[countryCode];
        }

        if(!countryObj)
            return;

        let rules = [];
        Object.keys(countryObj).forEach(function(key){
            const [digits, word] = countryObj[key][1].match(/\D+|\d+/g);
            rules.push(parseInt(digits));
        });


        let country = {};
        let str = this.field.value;
        let n = 0;

        Object.keys(countryObj).forEach(function(key){
            if(key == 'country'){
                country[`${key}`] = countryObj[key][3]
                str = str.substr(rules[n]);
            }else{
                const value = str.substr(0, rules[n]);
                country[`${key}`] = value;
                str = str.substr(rules[n]);
            }
            n+=1;
        });

        this.info = country;
    }
}
</script>
