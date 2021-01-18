/* Base config:
  ========================================================================== */

const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const webpack = require('webpack')
const WebpackBar = require('webpackbar')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')
const { VueLoaderPlugin } = require('vue-loader')
const { WebpackLaravelMixManifest } = require('webpack-laravel-mix-manifest')

// Main const
const PATHS = {
  client: path.join(__dirname, './resources/client'),
  public: path.join(__dirname, './public')
}

module.exports = {
  stats: 'errors-only',
  externals: {
    paths: PATHS
  },
  entry: {
    app: './resources/client/app.js'
    // module: `${PATHS.src}/your-module.js`,
  },
  output: {
    filename: 'js/[name].[hash].js',
    path: PATHS.public,
    /*
      publicPath: '/' - relative path for dist folder (js,css etc)
      publicPath: './' (dot before /) - absolute path for dist folder (js,css etc)
    */
    publicPath: '/'
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        vendor: {
          name: 'vendors',
          test: /node_modules/,
          chunks: 'all',
          enforce: true
        }
      }
    }
  },
  module: {
    rules: [
      {
        // JavaScript
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: '/node_modules/'
      },
      {
        // Vue
        test: /\.vue$/,
        loader: 'vue-loader',
        options: {
          loader: {
            scss: 'vue-style-loader!css-loader!sass-loader'
          }
        }
      },
      {
        // Fonts
        test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
        loader: 'file-loader',
        options: {
          name: 'fonts/[name].[ext]'
        }
      },
      {
        // images / icons
        test: /\.(png|jpg|gif|svg)$/,
        loader: 'file-loader',
        options: {
          name: 'images/[name].[ext]'
        }
      },
      {
        // scss
        test: /\.scss$/,
        use: [
          'style-loader',
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: { sourceMap: true }
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
              config: { path: './postcss.config.js' }
            }
          },
          {
            loader: 'sass-loader',
            options: { sourceMap: true }
          }
        ]
      },
      {
        // css
        test: /\.css$/,
        use: [
          'style-loader',
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: { sourceMap: true }
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: true,
              config: { path: './postcss.config.js' }
            }
          }
        ]
      }
    ]
  },
  resolve: {
    extensions: ['.ts', '.js', '.vue', '.json', '.css', '.scss'],
    alias: {
      '@': PATHS.client,
      vue$: 'vue/dist/vue.esm-bundler.js'
    },
    modules: ['node_modules']
  },
  plugins: [
    // Define Bundler Build Feature Flags
    new webpack.DefinePlugin({
      __VUE_OPTIONS_API__: true,
      __VUE_PROD_DEVTOOLS__: false
    }),
    new WebpackBar(),
    new VueLoaderPlugin(),
    new CleanWebpackPlugin({
      cleanOnceBeforeBuildPatterns: ['js/*', 'css/*', 'images/*', 'fonts/*', 'mix-manifest.json']
    }),
    new MiniCssExtractPlugin({
      filename: 'css/[name].[hash].css'
    }),
    // Write out mix-manifest.json to build directory.
    new WebpackLaravelMixManifest()
  ]
}
