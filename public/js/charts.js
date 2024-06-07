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
        // WIDTH FOR CHART
        width: "100%",
        // HEIGHT FOR CHART
        height: 280,
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
            opacityFrom: 1,
            opacityTo: 1,
            stops: [0, 100],
            colorStops: [
                {
                    offset: 0,
                    opacity: 0.5, // Ajusta la opacidad según lo tenue que desees el azul
                    color: "#F79501", // Puedes cambiar este color azul según tus preferencias
                },
                {
                    offset: 100,
                    opacity: 0.2, // Ajusta la opacidad según lo tenue que desees el azul
                    color: "#FEC570", // Puedes cambiar este color azul según tus preferencias
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
        {
            name: "Sales",
            data: [30, 65, 28, 70, 60, 80],
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
                            color: "red",
                        },
                        {
                            offset: 100,
                            opacity: 0.2,
                            color: "yellow",
                        },
                    ],
                },
            },
        },
        {
            name: "Expenses",
            data: [15, 50, 18, 85, 40, 90],
        },
    ],

    colors: [primaryColor, thirdColor],

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
