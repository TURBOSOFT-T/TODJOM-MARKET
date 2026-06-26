# --- Étape 1 : Build ---
FROM node:20-alpine AS builder
WORKDIR /app
COPY package*.json ./

# C'EST ICI QU'IL FAUT AJOUTER LE DRAPEAU :
RUN npm install --legacy-peer-deps

COPY . .
RUN npm run build

# --- Étape 2 : Production ---
FROM nginx:alpine
COPY --from=builder /app/build /usr/share/nginx/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]