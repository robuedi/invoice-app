<template>
    <div>
        <form @submit.prevent="getInvoices()" >
            <div class="form-row mt-3">
                <div class="col">
                    <input v-model="form.startDate" autocomplete="off" id="start_date" type="text" class="form-control" placeholder="Start date">
                </div>
                <div class="col">
                    <input v-model="form.endDate" autocomplete="off" id="end_date" type="text" class="form-control" placeholder="End date">
                </div>
                <div class="col">
                    <select v-model="form.location"  class="form-control">
                        <option></option>
                        <option v-for="location in locations" :value="location.id">{{location.name}}</option>
                    </select>
                </div>
                <div class="col">
                    <select v-model="form.status"  class="form-control">
                        <option></option>
                        <option v-for="status in statuses" :value="status.status">{{status.status}}</option>
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
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody >
                <tr v-for="invoice in invoices" :key="invoice.id">
                    <td>{{invoice.invoice_header.location.name}}</td>
                    <td>{{invoice.invoice_header.date}}</td>
                    <td>{{invoice.invoice_header.status}}</td>
                    <td>{{invoice.value}}</td>
                </tr>
                <tr v-if="!invoices.length"><td colspan="4">No records.</td></tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import Lightpick from 'lightpick';

    export default {
        data() {
            return {
                invoices: [],
                form: new Form({
                    startDate: '',
                    endDate: '',
                    location: '',
                    status: '',
                }),
                locations: [],
                statuses: []
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
            getInvoiceStatuses(){
                //get the invoices statuses
                axios.get('api/v1/invoice/statuses').then((res) => {
                    this.statuses = res.data.data;
                }).catch((error) => {
                    console.log(error)
                })
            },
            setDateRangerPicker(){
                //set the date picker
                var that = this;
                var picker = new Lightpick({
                    field: document.getElementById('start_date'),
                    secondField: document.getElementById('end_date'),
                    singleDate: false,
                    format: 'YYYY-MM-DD',
                    onClose: function (){
                        //solution between vue.js and Lightpick
                        that.form.startDate = document.getElementById('start_date').value;
                        that.form.endDate = document.getElementById('end_date').value;
                    }
                });
            },
            getInvoices(){
                let data = {
                    status: this.form.status,
                    location: this.form.location,
                    start_date: this.form.startDate,
                    end_date: this.form.endDate
                };

                //filter empty values
                Object.keys(data).forEach((key) => (data[key] === '') && delete data[key]);

                //get the invoices
                axios.get('api/v1/invoice', {
                    params: data
                }).then((res) => {
                    this.invoices = res.data.data;
                    this.form.reset();
                }).catch((error) => {
                    console.log(error)
                })
            }
        },
        mounted() {
            this.getLocations();
            this.getInvoiceStatuses();
            this.setDateRangerPicker();
            this.getInvoices();
        }
    }
</script>
