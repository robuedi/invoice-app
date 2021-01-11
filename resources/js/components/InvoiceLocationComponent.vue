<template>
    <div>
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
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            invoicesInfo: [
                {
                    id: 1,
                    value: 231,
                    status: 'pending',
                }
            ]
        }
    }
}
</script>
