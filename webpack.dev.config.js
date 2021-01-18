/* Development config:
  ========================================================================== */
const webpack = require('webpack')

// Source: https://github.com/survivejs/webpack-merge
const { merge } = require('webpack-merge')
// Base config
const baseWebpackConfig = require('./webpack.base.config')

const devWebpackConfig = merge(baseWebpackConfig, {
  mode: 'development',
  stats: 'errors-only',
  devtool: 'cheap-module-eval-source-map',
  devServer: {
    contentBase: baseWebpackConfig.externals.paths.public,
    port: 8081,
    overlay: {
      warnings: true,
      errors: true
    }
  },
  plugins: [
    new webpack.SourceMapDevToolPlugin({
      filename: '[file].map'
    })
  ]
})

module.exports = new Promise((resolve, reject) => {
  resolve(devWebpackConfig)
})
