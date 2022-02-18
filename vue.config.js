module.exports = {
  publicPath: process.env.NODE_ENV === 'production' ? '/' : '/',
  configureWebpack: {
    optimization: {
      splitChunks: {
        minSize: 10000,
        maxSize: 250000,
      },
    },
  },
  // https://stackoverflow.com/questions/61122635/vue-js-exclude-folders-from-webpack-bundle
  // this should remove all sites except default and the one you are compiling
  chainWebpack: (config) => {
    config.plugin('copy').tap(([options]) => {

      options[0].ignore.push('php/farm/.env.api.local.php')
      if (process.env.VUE_APP_UPGRADE == 'minor') {
        site = 'node_modules/*'
        options[0].ignore.push(site)
        site = 'ckfinder/**'
        options[0].ignore.push(site)
        site = 'ckeditor/**'
        options[0].ignore.push(site)
        site = 'vendor/**'
        options[0].ignore.push(site)
      }
      return [options]
    })
  },
}
