<template>
  <vue3-chart-js v-bind="{ ...lineChart }" />
</template>

<script>
import Vue3ChartJs from "@j-t-mcc/vue3-chartjs";
import zoomPlugin from "chartjs-plugin-zoom";
import dataLabels from "chartjs-plugin-datalabels";

// globally registered and available for all charts
Vue3ChartJs.registerGlobalPlugins([zoomPlugin]);

export default {
    name: "App",
    components: {
        Vue3ChartJs,
    },
    props: {
        options: {
            type: Object,
            default() {
                return {};
            }
        },
    },
    setup(props) {
        const lineChart = {
            type: "line",
            // locally registered and available for this chart
            plugins: [dataLabels],
            data: {
                labels: props.options.dates,
                datasets: [
                    {
                        label: "Channel Plays",
                        data: props.options.total,
                        fill: false,
                        tension: 0.5,
                        borderColor: "#6366F1",
                        backgroundColor: "black",
                    },
                ],
            },
            options: {
                plugins: {
                    zoom: {
                        zoom: {
                            wheel: {
                                enabled: true,
                            },
                            pinch: {
                                enabled: true,
                            },
                            mode: "y",
                        },
                    },
                    datalabels: {
                        backgroundColor: function (context) {
                            return context.dataset.backgroundColor;
                        },
                        borderRadius: 4,
                        color: "white",
                        font: {
                            weight: "bold",
                        },
                        formatter: Math.round,
                        padding: 6,
                        height: 200
                    },
                },
            },
        };

        return {
            lineChart,
        };
    },
};
</script>

<style>

</style>