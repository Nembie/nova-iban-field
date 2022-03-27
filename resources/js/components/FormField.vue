<template>
	<default-field :field="field" :errors="errors" :show-help-text="showHelpText">
		<template slot="field">
		<input
			class="w-full form-control form-input form-input-bordered"
			:placeholder="field.name"
			:class="errorClasses"
			@input="handleInput"
			:id="field.name"
			v-model="value"
			type="text"
			@keypress="onEnterPressed"
		/>
			<p v-if="!error && this.value != ''" class="mt-3 text-success">
                {{ '✔ ' + __('iban_is_valid') }}
            </p>
			<p v-else-if="error" class="mt-3 text-danger">
                {{  '✖ '+ __('iban_is_not_valid') }}
            </p>
		</template>
	</default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import { validateIban } from "../func";

export default {
	mixins: [FormField, HandlesValidationErrors],
	props: ['resourceName', 'resourceId', 'field'],
	data: function() {
		return {
			error: false
		}
	},
	
	methods: {
		onEnterPressed(e) {
			if(
				e.charCode === 13
				&& !validateIban(this.value)
			){
				e.preventDefault();
			}
		},

		handleInput(event) {
			this.error = event.target.value === "" ? false : !validateIban(event.target.value);
		},

		/*
		* Set the initial, internal value for the field.
		*/
		setInitialValue() {
			this.value = this.field.value || ''
		},
		
		/**
		* Fill the given FormData object with the field's internal value.
		*/
		fill(formData) {
			formData.append(this.field.attribute, this.value || '')
		},
	},
}
</script>
