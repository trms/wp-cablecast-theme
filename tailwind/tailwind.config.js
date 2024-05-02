// Set the Preflight flag based on the build target.
const includePreflight = 'editor' === process.env._TW_TARGET ? false : true;
const colors = require('tailwindcss/colors');
const plugin = require('tailwindcss/plugin');

module.exports = {
	presets: [
		// Manage Tailwind Typography's configuration in a separate file.
		require('./tailwind-typography.config.js'),
	],
	content: [
		// Ensure changes to PHP files and `theme.json` trigger a rebuild.
		'./theme/**/*.php',
	],
	theme: {
		// Extend the default Tailwind theme.
		extend: {
			...colors,
			colors: {
				'brand-main': '#2DB566',
				'brand-secondary': '#545C6E',
				'brand-accent': '#3192C8',
			},
		},
	},
	corePlugins: {
		// Disable Preflight base styles in builds targeting the editor.
		preflight: includePreflight,
	},
	plugins: [
		// Add Tailwind Typography (via _tw fork).
		require('@_tw/typography'),

		// Extract colors and widths from `theme.json`.
		require('@_tw/themejson'),

		// Uncomment below to add additional first-party Tailwind plugins.
		// require('@tailwindcss/forms'),
		// require('@tailwindcss/aspect-ratio'),
		// require('@tailwindcss/container-queries'),
		plugin(function ({ addComponents }) {
			addComponents({
				'.btn': {
					padding: '.5rem 1rem',
					fontWeight: '600',
				},
				'.btn-primary': {
					backgroundColor: '#2DB566',
					color: '#fff',
					'&:hover': {
						backgroundColor: '#289e5c',
					},
				},
			});
		}),
	],
};
