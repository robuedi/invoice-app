<template>
    <div>
        <button class="btn btn-info" @click="toggleAdvancedFiltering()">Advanced Filtering</button>
        <button class="btn btn-success" @click="toggleLocationBasedFiltering()">Location Based Filtering</button>
        <InvoiceIndexComponent v-if="advancedFiltering"/>
        <InvoiceLocationComponent v-if="locationBasedFiltering"/>
    </div>
</template>

<script>
    import InvoiceIndexComponent from "./InvoiceIndexComponent";
    import InvoiceLocationComponent from "./InvoiceLocationComponent";

    export default {
        data() {
            return {
                advancedFiltering: true,
                locationBasedFiltering: false
            }
        },
        components: {
            InvoiceIndexComponent,
            InvoiceLocationComponent
        },
        methods: {
            toggleAdvancedFiltering(){
                this.advancedFiltering = !this.advancedFiltering

                //show only on filtering type
                if(this.advancedFiltering === true){
                    this.locationBasedFiltering = false
                }
            },
            toggleLocationBasedFiltering(){
                this.locationBasedFiltering = !this.locationBasedFiltering

                //show only on filtering type
                if(this.locationBasedFiltering === true){
                    this.advancedFiltering = false
                }
            }
        }
    }
</script>
