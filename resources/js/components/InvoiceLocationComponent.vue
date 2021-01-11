<template>
    <div>
        <form @submit.prevent="getInvoices()" >
            <div class="form-row mt-3">
                <div class="col">
                    <select v-model="form.location"  class="form-control">
                        <option></option>
                        <option v-for="location in locations" :value="location.id">{{location.name}}</option>
                    </select>
                </div>
            </div>
            <div class="clearfix mb-2 mt-2">
                <button type="submit" class="btn btn-success float-right">Submit</button>
            </div>
        </form>
        <table class="table table-striped mt-3 editable-table">
            <thead>
                <tr>
                    <th>Value</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody >
                <tr v-for="invoiceInfo in invoicesInfo" :key="invoiceInfo.id">
                    <td>{{invoiceInfo.value}}</td>
                    <td>{{invoiceInfo.status}}</td>
                </tr>
                <tr v-if="!invoicesInfo.length"><td colspan="4">No records.</td></tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    data() {
        return {
            invoicesInfo: [],
            locations: [],
            form: new Form({
                location: ''
            })
        }
    },
    methods: {
        getLocations(){
            //get the locations
            axios.get('api/v1/location').then((res) => {
                this.locations = res.data.data;
            }).catch((error) => {
                console.log(error)
            })
        },
        getInvoices(){
            let data = {
                location: this.form.location
            };

            //filter empty values
            Object.keys(data).forEach((key) => (data[key] === '') && delete data[key]);

            //get the invoices
            axios.get('api/v1/invoice/info-location', {
                params: data
            }).then((res) => {
                this.invoicesInfo = res.data.data;
                this.form.reset();
            }).catch((error) => {
                console.log(error)
            })
        }
    },
    mounted() {
        this.getLocations();
        this.getInvoices();
    }
}
</script>
