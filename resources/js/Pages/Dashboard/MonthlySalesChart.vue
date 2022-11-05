<template>
    <div>
        <VueApexCharts
            width="100%"
            height="450"
            type="line"
            :options="options"
            :series="series"
        ></VueApexCharts>
    </div>
</template>

<script setup>
import VueApexCharts from "vue3-apexcharts";

const data = defineProps({
    net_revenue_month: {
        type: Array,
    },
    month: {
        type: Array,
    },
});

const options = {
    chart: {
        id: "basic-bar",
        animations: {
            speed: 500,
        },
        dropShadow: {
            enabled: true,
            color: "#000",
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2,
        },
        // stacked: true,
    },
    colors: ["#0064ff", "#FF5B00"],
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "75%",
            endingShape: "rounded",
            distributed: true,
            borderRadius: 5,
        },
    },
    dataLabels: {
        enabled: true,
        style: {
            colors: undefined,
        },
        formatter: function (value) {
            return value.toLocaleString();
        },
    },
    legend: {
        show: true,
        offsetY: 8,
    },
    stroke: {
        show: true,
        curve: "smooth",
        // colors: ["transparent"],
    },
    xaxis: {
        categories: data.month,
    },
    yaxis: {
        title: {
            text: "Nett Revenue",
        },
        labels: {
            formatter: function (value) {
                return "IDR " + (value / 1000).toLocaleString() + "K";
            },
        },
    },
    fill: {
        opacity: 0.7,
    },
    // tooltip: {
    //     y: {
    //         formatter: function (val) {
    //             return val;
    //         },
    //     },
    // },
    theme: {
        pallete: "palette3",
    },
    title: {
        text: "Monthly Nett Revenue This Year",
        style: {
            fontSize: "18px",
            fontWeight: "bold",
            color: "#263238",
        },
    },
};

const series = [
    {
        name: "Nett Revenue",
        data: data.net_revenue_month,
    },
];
</script>
