# =========================
# 1. BUILD STAGE
# =========================
FROM node:20-alpine AS builder

WORKDIR /app

# Copier seulement dépendances (cache Docker)
COPY package*.json ./

# Installation stable
RUN npm ci --legacy-peer-deps

# Copier le reste du projet
COPY . .

# Build React
RUN npm run build


# =========================
# 2. PRODUCTION STAGE
# =========================
FROM nginx:alpine

# Supprimer config default nginx (BONNE PRATIQUE)
RUN rm -rf /etc/nginx/conf.d/default.conf

# Copier build React
COPY --from=builder /app/build /usr/share/nginx/html

# Ajouter config nginx custom (option recommandé)
COPY nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]