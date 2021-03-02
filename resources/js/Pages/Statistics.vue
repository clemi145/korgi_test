<template>
<line-chart :chart-data="arrPositive" :options="chartOptions" label="Positive"></line-chart>
</template>

<script>
import axios from "axios";
import moment from "moment";
import LineChart from "@/Pages/LineChart";

export default {
    name: "Statistics",
    components: {
        LineChart,
    },

    data() {
        return {
            arrPositive: [],
            arrHospitalized: [],
            arrInCu: [],
            arrOnVentilators: [],
            arrRecovered: [],
            arrDeaths: [],
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
            }
        };

    },
    async created() {
        const {data} = await axios.get("https://covidtracking.com/api/us/daily");

        data.forEach(d => {
            const date = moment(d.date, "YYYYMMDD").format("MM/DD");

            const {
                positive,
                hospitalizedCurrently,
                inIcuCurrently,
                onVentilatorCurrently,
                recovered,
                death
            } = d;

            this.arrPositive.push({date, total: positive});
            this.arrHospitalized.push({date, total: hospitalizedCurrently});
            this.arrInCu.push({date, total: inIcuCurrently});
            this.arrOnVentilators.push({date, total: onVentilatorCurrently});
            this.arrRecovered.push({date, total: recovered});
            this.arrDeaths.push({date, total: death});
        })
    }
    }
</script>

<style scoped>

</style>
