/* export const server = "https://todjom.greenlyfes.com/api";

export const backend_url = "https://todjom.greenlyfes.com/api";

export const api = "https://todjom.greenlyfes.com/api";
export const image = "https://todjom.greenlyfes.com";

 */
/* 
export const server ="https://localhost:8000/api";




 export const image ="https://localhost:8000/api"; */

 // 1. On récupère dynamiquement l'URL configurée dans le fichier .env de la machine active
// Si la variable n'est pas définie (ex: en local), on met l'adresse locale par défaut
const BASE_URL = process.env.NEXT_PUBLIC_API_URL || "http://127.0.0.1:8000/api";

// 2. On extrait l'URL racine (sans le /api) pour la gestion des images et des assets
const ROOT_URL = BASE_URL.replace('/api', '');

export const server = BASE_URL;
export const backend_url = BASE_URL;
export const api = BASE_URL;
export const image = ROOT_URL;