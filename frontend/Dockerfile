# frontend/Dockerfile
FROM node:20-alpine

WORKDIR /app

# Copier les fichiers de dépendances
COPY package*.json ./

# Installer les dépendances
RUN npm install

# Copier le reste du code
COPY . .

EXPOSE 5173

# Lancer le serveur de dev Vite
CMD ["npm", "run", "dev", "--", "--host"]