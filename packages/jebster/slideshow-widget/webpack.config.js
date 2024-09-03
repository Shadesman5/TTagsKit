module.exports = [

    {
        entry: {
            "widget-slideshow": "./app/components/widget-slideshow.vue"
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        module: {
            loaders: [
                { test: /\.vue$/, loader: "vue" }
            ]
        }
    }

];
