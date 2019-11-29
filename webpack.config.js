var UglifyJsPlugin = require('uglifyjs-webpack-plugin')
var debug = process.env.NODE_ENV !== "production";
var webpack = require('webpack');
var path = require('path');
var OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
var MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
  devtool: 'source-map',
  mode: 'development',
  entry: {
    'backend'                         : ['./assets/js/backend.js', './assets/scss/backend.scss'],
    'customize'                       : './assets/js/customize.js',
    'customize-live-preview'          : './assets/js/customize-live-preview.js',
    'frontend'                        : ['./assets/js/frontend.js', './assets/scss/frontend.scss'],
    'portfolio'                       : ['./assets/scss/portfolio.scss'],
    'team'                            : ['./assets/scss/team.scss'],
    'extends-designer-frontend'       : './assets/js/extends-designer-frontend.js',
  },
  output: {
    path: __dirname + "/assets/dist",
    filename: "jayla-[name].bundle.js"
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
      {
          test: /\.css$/,
          use: [
              MiniCssExtractPlugin.loader,
              { loader: 'css-loader', options: { url: false, sourceMap: true } }
          ]
      },
      {
          test: /\.scss$/,
          use: [
              MiniCssExtractPlugin.loader,
              { loader: 'css-loader', options: { url: false, sourceMap: true } },
              { loader: 'sass-loader', options: { sourceMap: true } }
          ]
      }
    ]
  },
  optimization: {
    minimizer: [
      new UglifyJsPlugin({
        cache: true,
        parallel: true,
        sourceMap: true // set to true if you want JS source maps
      }),
      new OptimizeCSSAssetsPlugin()
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: "../css/jayla-[name].bundle.css",
      chunkFilename: "../css/jayla-[id].bundle.css",
    })
  ]
};
