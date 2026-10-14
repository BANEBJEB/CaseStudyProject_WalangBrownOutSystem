import { useEffect, useState } from 'react';
import { alertApi } from '../api/endpoints';

export default function Alerts() {
  const [alerts, setAlerts] = useState([]);

  const load = () => alertApi.list().then((res) => setAlerts(res.data));

  useEffect(() => {
    load();
  }, []);

  return (
    <div className="p-6 max-w-6xl mx-auto">
      <h1 className="text-3xl font-bold mb-6">Alerts</h1>
      <div className="card p-6 space-y-3">
        {alerts.length === 0 ? (
          <p className="text-latte">No active alerts.</p>
        ) : (
          alerts.map((alert) => (
            <div
              key={alert.id}
              className={`p-4 rounded-md border-l-4 flex justify-between items-start ${
                alert.severity === 'CRITICAL'
                  ? 'bg-red-50 border-red-700'
                  : 'bg-amber-50 border-gold'
              }`}
            >
              <div>
                <p className="font-semibold text-espresso">{alert.alert_type}</p>
                <p className="text-sm text-mocha mt-1">{alert.message}</p>
                {alert.recommended_action && (
                  <p className="text-xs italic text-latte mt-2">
                    {alert.recommended_action}
                  </p>
                )}
              </div>
              <button
                onClick={() => alertApi.resolve(alert.id).then(load)}
                className="text-xs px-3 py-1 bg-cream text-espresso rounded border border-caramel hover:bg-foam font-semibold"
              >
                Resolve
              </button>
            </div>
          ))
        )}
      </div>
    </div>
  );
}