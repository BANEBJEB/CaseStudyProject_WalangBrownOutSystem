import { useEffect, useState } from 'react';
import { alertApi, productApi } from '../api/endpoints';

export default function Dashboard() {
  const [alerts, setAlerts] = useState([]);
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    Promise.all([alertApi.list(), productApi.list()])
      .then(([a, p]) => {
        setAlerts(a.data);
        setProducts(p.data);
      })
      .finally(() => setLoading(false));
  }, []);

  const runHealthCheck = async () => {
    await alertApi.runHealthCheck();
    const res = await alertApi.list();
    setAlerts(res.data);
  };

  if (loading) {
    return <div className="p-8 text-mocha">Brewing data...</div>;
  }

  return (
    <div className="p-6 max-w-6xl mx-auto">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-3xl font-bold">Inventory Dashboard</h1>
        <button onClick={runHealthCheck} className="btn-primary">
          Run Health Check
        </button>
      </div>

      <div className="grid grid-cols-4 gap-4 mb-8">
        <div className="card p-4">
          <p className="text-xs text-mocha uppercase tracking-wide">Total Products</p>
          <p className="text-3xl font-bold text-espresso mt-1">{products.length}</p>
        </div>
        <div className="card p-4">
          <p className="text-xs text-mocha uppercase tracking-wide">Active Alerts</p>
          <p className="text-3xl font-bold text-espresso mt-1">{alerts.length}</p>
        </div>
        <div className="card p-4">
          <p className="text-xs text-mocha uppercase tracking-wide">Critical</p>
          <p className="text-3xl font-bold text-espresso mt-1">
            {alerts.filter((a) => a.severity === 'CRITICAL').length}
          </p>
        </div>
        <div className="card p-4">
          <p className="text-xs text-mocha uppercase tracking-wide">Warnings</p>
          <p className="text-3xl font-bold text-espresso mt-1">
            {alerts.filter((a) => a.severity === 'WARNING').length}
          </p>
        </div>
      </div>

      <div className="card p-6 mb-8">
        <h2 className="text-xl font-bold mb-4">Active Alerts</h2>
        {alerts.length === 0 ? (
          <p className="text-latte">No active alerts. Everything is smooth.</p>
        ) : (
          <div className="space-y-3">
            {alerts.map((alert) => (
              <div
                key={alert.id}
                className={`p-4 rounded-md border-l-4 ${
                  alert.severity === 'CRITICAL'
                    ? 'bg-red-50 border-red-700'
                    : 'bg-amber-50 border-gold'
                }`}
              >
                <p className="font-semibold text-espresso">{alert.alert_type}</p>
                <p className="text-sm text-mocha mt-1">{alert.message}</p>
              </div>
            ))}
          </div>
        )}
      </div>

      <div className="card p-6">
        <h2 className="text-xl font-bold mb-4">Products</h2>
        <div className="overflow-hidden rounded-md">
          <table className="w-full text-sm">
            <thead>
              <tr>
                <th className="text-left p-3">SKU</th>
                <th className="text-left p-3">Product</th>
                <th className="text-left p-3">Category</th>
                <th className="text-left p-3">Price</th>
                <th className="text-left p-3">Seasonality</th>
              </tr>
            </thead>
            <tbody>
              {products.map((p) => (
                <tr key={p.id}>
                  <td className="p-3 font-mono text-xs text-mocha">{p.sku}</td>
                  <td className="p-3 font-medium text-espresso">{p.product_name}</td>
                  <td className="p-3">
                    <span className="inline-block px-2 py-1 rounded-full text-xs font-semibold bg-caramel text-foam">
                      {p.category}
                    </span>
                  </td>
                  <td className="p-3 text-espresso">
                    PHP {Number(p.unit_price).toLocaleString()}
                  </td>
                  <td className="p-3 text-mocha">{p.seasonality}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}