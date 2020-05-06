const path = require( 'path' );

const config = {
	entry: {
		// frontend and backend will replace the [name] portion of the output config below.
		frontend: './src/frontend/app.js',
		backend: './src/backend/app.js'
	},
	output: {
		// [name] allows for the entry object keys to be used as file names.
		filename: 'js/[name].js',
		path: path.resolve( __dirname, 'dist' )
	},
	module: {
		rules: [
			// JavaScript
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: 'babel-loader'
			},
			// SASS, SCSS
			{
				test: /\.s[ac]ss$/i,
				use: [
					'style-loader',
					'css-loader',
					{
						loader: 'sass-loader',
						options: {
							implementation: require('sass'),
						},
					},
				],
			},
			// FONTS
			{
				test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
				use: [
						{
						loader: 'file-loader',
						options: {
						name: '[name].[ext]',
						outputPath: 'fonts/'
						}
					}
				]
			}
		]
	}
}

module.exports = config;