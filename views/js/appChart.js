let primaryColor = getComputedStyle(document.documentElement)
    .getPropertyValue("--primary-color")
    .trim();

let thirdColor = getComputedStyle(document.documentElement)
    .getPropertyValue("--third-color")
    .trim();

let labelColor = getComputedStyle(document.documentElement)
    .getPropertyValue("--color-label")
    .trim();

let fontFamily = getComputedStyle(document.documentElement)
    .getPropertyValue("--font-family")
    .trim();

let defaultOptions = {
    chart: {
        tollbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
        width: "100%",
        hight: 180,
        offsetY: 18,
    },

    dataLabels: {
        enabled: false,
    },
};

let barOptions = {
    ...defaultOptions,

    chart: {
        ...defaultOptions.chart,
        type: "area",
    },

    tooltip: {
        enabled: true,
        style: {
            fontFamily: fontFamily,
        },
        y: {
            formatter: (value) => `${value}k`,
        },
    },
    series: [
        {
            name: "Stocks",
            data: [15, 50, 18, 90, 30, 65],
        },
    ],

    colors: [primaryColor],
    fill: {
        type: "gradient",
        gradient: {
            type: "vertical",
            opacityForm: 1,
            opacityTo: 0,
            stops: [0, 100],
            colorStops: [
                {
                    offset: 0,
                    opacity: 0.2,
                    color: "#ffffff",
                },
                {
                    offset: 100,
                    opacity: 0.2,
                    color: "#ffffff",
                },
            ],
        },
    },
    stroke: {
        colors: [primaryColor],
        lineCap: "round",
    },

    grid: {
        borderColor: "rgba(0, 0, 0, 0)",
        padding: {
            top: -30,
            right: 0,
            bottom: -8,
            left: 12,
        },
    },
    markers: {
        strokeColors: primaryColor,
    },
    yaxis: {
        show: false,
    },

    xaxis: {
        labels: {
            show: true,
            floating: true,
            style: {
                colors: labelColor,
                fontFamily: fontFamily,
            },
        },
        axisBorder: {
            show: false,
        },
        crosshairs: {
            show: false,
        },
        categories: ["Jan", "Mar", "May", "July", "Sept", "Nov"],
    },
};

let chart = new ApexCharts(document.querySelector(".chart-area"), barOptions);
chart.render();

let expensesAndSales = {
    chart: {
        tollbar: {
            show: false,
        },
        zoom: {
            enabled: false,
        },
        width: "100%",
        hight: 180,
        offsetY: 18,
    },

    dataLabels: {
        enabled: false,
    },
};

let barOptionsExSa = {
    ...defaultOptions,

    chart: {
        ...defaultOptions.chart,
        type: "area",
    },

    tooltip: {
        enabled: true,
        style: {
            fontFamily: fontFamily,
        },
        y: {
            formatter: (value) => `$ ${value} `,
        },
    },
    series: [
        { name: "Sales", data: [30, 68, 38, 51, 60, 80] },
        {
            name: "Expenses",
            data: [11, 52, 65, 20, 40, 90],
        },
    ],

    colors: [primaryColor, thirdColor],
    fill: {
        type: "gradient",
        gradient: {
            type: "vertical",
            opacityForm: 1,
            opacityTo: 0,
            stops: [0, 100],
            colorStops: [
                {
                    offset: 0,
                    opacity: 0.2,
                    color: "#ffffff",
                },
                {
                    offset: 100,
                    opacity: 0.2,
                    color: "#ffffff",
                },
            ],
        },
    },
    stroke: {
        colors: [primaryColor, thirdColor],
        lineCap: "round",
    },

    grid: {
        borderColor: "rgba(0, 0, 0, 0)",
        padding: {
            top: -30,
            right: 0,
            bottom: -8,
            left: 12,
        },
    },
    markers: {
        strokeColors: primaryColor,
    },
    yaxis: {
        show: false,
    },

    xaxis: {
        labels: {
            show: true,
            floating: true,
            style: {
                colors: labelColor,
                fontFamily: fontFamily,
            },
        },
        axisBorder: {
            show: false,
        },
        crosshairs: {
            show: false,
        },
        categories: ["Jan", "Mar", "May", "July", "Sept", "Nov"],
    },
};

let chartExSa = new ApexCharts(
    document.querySelector(".chart-ExSa"),
    barOptionsExSa
);
chartExSa.render();
