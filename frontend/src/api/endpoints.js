import api from './axios';

export const productApi = {
  list: () => api.get('/products'),
  create: (data) => api.post('/products', data),
  update: (id, data) => api.put(`/products/${id}`, data),
  delete: (id) => api.delete(`/products/${id}`),
};

export const alertApi = {
  list: () => api.get('/alerts'),
  resolve: (id) => api.patch(`/alerts/${id}/resolve`),
  runHealthCheck: () => api.post('/alerts/run-health-check'),
};

export const reorderApi = {
  list: () => api.get('/reorder-points'),
  calculate: (productId) => api.get(`/reorder-points/${productId}/calculate`),
};