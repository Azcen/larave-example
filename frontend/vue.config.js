const webpack = require('webpack')
const PACKAGE = require('./package.json')
const banner = `${PACKAGE.description}
 ${PACKAGE.version}

 ${new Date().getFullYear()}, ${PACKAGE.author}
 ${PACKAGE.homepage}

`

module.exports = {
  transpileDependencies: ['vuetify'],

  devServer: {
    proxy: 'http://laravel-example.test'
  },

  configureWebpack: {
    plugins: [new webpack.BannerPlugin(banner)],
    optimization: {
      runtimeChunk: 'single',
      splitChunks: {
        chunks: 'all',
        maxInitialRequests: Infinity,
        minSize: 0,
        cacheGroups: {
          vendor: {
            test: /[\\/]node_modules[\\/]/,
            name(module) {
              const packageName = module.context.match(
                /[\\/]node_modules[\\/](.*?)([\\/]|$)/
              )[1]
              return `npm.${packageName.replace('@', '')}`
            }
          }
        }
      }
    }
  },
  // output built static files to Laravel's public dir.
  // note the "build" script in package.json needs to be modified as well.
  outputDir: '../public',

  // modify the location of the generated HTML file.
  // make sure to do this only in production.
  indexPath:
    process.env.NODE_ENV === 'production'
      ? '../resources/views/index.blade.php'
      : 'index.html'
}
