/** @type { import('@storybook/server').Preview } */
const preview = {
  parameters: {
    server: {
      url: process.env.STORYBOOK_SERVER_URL,
    },
    controls: {
      matchers: {
        color: /(background|color)$/i,
        date: /Date$/i,
      },
    },
  },
};

export default preview;
