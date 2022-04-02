<template>
	<div class="mt-1" style="width: 200px!important">
		<span>{{ valueShowed }}</span>
		<div v-if="!field.hideActionsOnIndex">
			<a @click="toggleVisibility" class="text-primary">{{show ? __('Hide') : __('Show')}}</a>
			<span class="px-1">·</span>
			<a @click="copy" :class="isCopied ? 'text-success' : 'text-primary'">{{isCopied ? __('Copied') : __('Copy')}}</a>
		</div>
	</div>
</template>

<script>

export default {
	props: ['resourceName', 'field'],
	data: function() {
		return {
			show: true,
			value: this.field.value,
			valueShowed: this.field.value,
			isCopied: false,
		}
	},
	mounted() {
		if(
			this.field.alwaysHideOnIndex
			&& !this.field.hideActionsOnIndex
		){
			this.show = false;
			let valueShowed = '';
			for (let index = 0; index < this.value.length; index++)
				valueShowed += '*';
			this.valueShowed = valueShowed;
		}
    },
	methods: {
		/**
		 * Show/hide "Crypted" IBAN on index page
		 */
		toggleVisibility(){
			if(this.show){
				this.show = false;
				let valueShowed = '';
				for (let index = 0; index < this.value.length; index++)
					valueShowed += '*';
				this.valueShowed = valueShowed;
			}else{
				this.show = true;
				this.valueShowed = this.value;
			}
		},
		/**
		 * Copy password to clipboard
		 */
		async copy() {
			if(
				this.isCopied
				|| this.value === ""
			){
				return;
			}

			this.isCopied = true;
			let dummyComponentToCopy = document.createElement('input'),
			textToCopy = this.value;
			document.body.appendChild(dummyComponentToCopy);
			dummyComponentToCopy.value = textToCopy;
			dummyComponentToCopy.select();
			document.execCommand('copy');
			document.body.removeChild(dummyComponentToCopy);
			
			const vm = this;
			setTimeout(
				function(){
					vm.isCopied = false;
				}
			, 2000);
		}
    }
}
</script>
