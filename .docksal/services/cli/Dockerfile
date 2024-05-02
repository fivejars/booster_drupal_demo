FROM docksal/cli:php8.2-3.6

# Install image optimization apt packages
RUN apt-get update && apt-get install pngquant -y && apt-get install jpegoptim -y \
    # Cleanup
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# nvm/node/npm are only available in the docker user context
USER docker

ENV NODE_VERSION=16.20.2

# Install additional global npm dependencies
RUN set -e; \
    # Initialize the user environment (this loads nvm)
    . /home/docker/.profile; \
    # Install the necessary nodejs version
    nvm install $NODE_VERSION; \
    nvm alias default $NODE_VERSION; \
    nvm use $NODE_VERSION;

# Always switch back to root in the end
USER root
