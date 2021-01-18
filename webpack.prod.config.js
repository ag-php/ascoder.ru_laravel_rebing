/* Build config:
  ========================================================================== */

// Source: https://github.com/survivejs/webpack-merge
const { merge } = require('webpack-merge')
// Base config
const baseWebpackConfig = require('./webpack.base.config')

const buildWebpackConfig = merge(baseWebpackConfig, {
  mode: 'production',
  stats: 'errors-only',
  performance: {
    hints: false,
    maxEntrypointSize: 512000,
    maxAssetSize: 512000
  },
  plugins: []
})

module.exports = new Promise((resolve, reject) => {
  resolve(buildWebpackConfig)
})
