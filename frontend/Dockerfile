# Use Node for development
FROM node:20-alpine

WORKDIR /app

# Install dependencies first (for caching)
COPY package*.json ./
RUN npm install

# Copy the rest of the code
COPY . .

# Expose Vite's default port
EXPOSE 5173

# Run Vite with --host to allow external access
CMD ["npm", "run", "dev", "--", "--host"]