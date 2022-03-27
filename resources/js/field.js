Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-iban-field', require('./components/IndexField'))
  Vue.component('detail-nova-iban-field', require('./components/DetailField'))
  Vue.component('form-nova-iban-field', require('./components/FormField'))
})
