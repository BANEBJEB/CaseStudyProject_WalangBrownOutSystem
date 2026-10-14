import { useEffect, useState } from 'react';
import { productApi } from '../api/endpoints';

export default function Products() {
  const [products, setProducts] = useState([]);

  useEffect(() => {
    productApi.list().then((res) => setProducts(res.data));
  }, []);

  return (
    <div className="p-6 max-w-6xl mx-auto">
      <h1 className="text-3xl font-bold mb-6">Products</h1>
      <div className="card p-6">
        <div className="overflow-hidden rounded-md">
          <table className="w-full text-sm">
            <thead>
              <tr>
                <th className="text-left p-3">ID</th>
                <th className="text-left p-3">SKU</th>
                <th className="text-left p-3">Name</th>
                <th className="text-left p-3">Category</th>
                <th className="text-left p-3">Price</th>
              </tr>
            </thead>
            <tbody>
              {products.map((p) => (
                <tr key={p.id}>
                  <td className="p-3 font-mono text-xs text-mocha">{p.id}</td>
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
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}