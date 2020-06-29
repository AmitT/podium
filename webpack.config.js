const path = require('path'),
    MiniCssExtractPlugin = require('mini-css-extract-plugin'),
    BrowserSyncPlugin = require('browser-sync-webpack-plugin'),
    { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
    entry: {
        vue: ['./node_modules/vue/dist/vue.runtime.common.js'],
        main: [
            './assets/scripts/main.js',
            // './assets/styles/main.scss'
        ],
        home: [
            './assets/scripts/pages/home.js',
            // './assets/styles/pages/home.scss'
        ],
    },
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'scripts/[name].js',
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true,
                            sassOptions: {
                                outputStyle: 'compressed',
                            },
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: 'styles/[name].css',
        }),
        new BrowserSyncPlugin({
            proxy: 'http://localhost/~amit/podium/public_html/',
            port: 3000,
            watch: [
                'inc/**/*.php',
                'template-parts/**/*.php',
                'assets/scripts/**/*.js',
                'assets/styles/**/*.scss',
            ],
        }),
    ],
};
