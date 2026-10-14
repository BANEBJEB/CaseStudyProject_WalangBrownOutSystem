import { BrowserRouter, Routes, Route, Link, useLocation } from 'react-router-dom';
import Dashboard from './pages/Dashboard';
import Products from './pages/Products';
import Alerts from './pages/Alerts';

function NavBar() {
  const location = useLocation();

  const linkClass = (path) =>
    `px-4 py-2 rounded-md font-semibold transition ${
      location.pathname === path
        ? 'bg-gold text-espresso'
        : 'text-foam hover:bg-roast'
    }`;

  return (
    <nav className="bg-roast shadow-md">
      <div className="max-w-6xl mx-auto px-4 py-3 flex items-center gap-6">
        <span className="text-foam font-bold text-lg tracking-wide">
          Walang Brownout
        </span>
        <div className="flex gap-2">
          <Link to="/" className={linkClass('/')}>Dashboard</Link>
          <Link to="/products" className={linkClass('/products')}>Products</Link>
          <Link to="/alerts" className={linkClass('/alerts')}>Alerts</Link>
        </div>
      </div>
    </nav>
  );
}

export default function App() {
  return (
    <BrowserRouter>
      <NavBar />
      <Routes>
        <Route path="/" element={<Dashboard />} />
        <Route path="/products" element={<Products />} />
        <Route path="/alerts" element={<Alerts />} />
      </Routes>
    </BrowserRouter>
  );
}