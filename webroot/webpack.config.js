var webpack = require('webpack')
var debug = process.env.NODE_ENV !== "production";
module.exports = function(env) {
    return {
        entry:{
            "bundle-js": __dirname + "/dist/app-js.js",
            "bundle-css": __dirname + "/dist/app-css.js",
            "bundle-js.min": __dirname + "/dist/app-js.js",
            "bundle-css.min": __dirname + "/dist/app-css.js"
        }, 
        
        output: {
            path: __dirname + "/dist",
            filename: "[name].js"
        },
        plugins: [
            new webpack.optimize.UglifyJsPlugin({
                mangle: false, 
                sourcemap: false,
                include: /\.min\.js$/,
                minimize: true
            }),
        ],
        module: {
            loaders: [
                {
                    test: /\.html$/, 
                    loader: 'raw-loader', 
                    exclude: /node_modules/
                },
                {
                    test: /\.css$/, 
                    loader: "style-loader!css-loader", 
                    exclude: /node_modules/
                },
                {
                    test: /\.scss$/, 
                    loader: "style-loader!css-loader!sass-loader", 
                    exclude: /node_modules/
                },
                {
                    test: /\.woff($|\?)|\.woff2($|\?)|\.ttf($|\?)|\.eot($|\?)|\.svg($|\?)|\.jpg($|\?)|\.png($|\?)/, 
                    loader: 'url-loader'
                }
            ]
        },
    }
}