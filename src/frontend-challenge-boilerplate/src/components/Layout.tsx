import { FileProvider } from "@/context";
import { ReactElement } from "react";
import { NavLink, Outlet } from "react-router-dom";

function Layout(): ReactElement {
  return (
    <>
      <header className="max-h-20 w-full flex-1 bg-slate-200 py-4 px-6">
        <nav>
          <ul className="flex justify-center items-center gap-4">
            <li className="list-none">
              <NavLink
                to="/"
                className="no-underline"
              >
                {({ isActive }) => (
                  <div className={`py-2 px-4 rounded-lg ${isActive && "bg-green-50"} hover:bg-slate-300 transition-all`}>
                    <span className={isActive ? "font-semibold text-green-700" : "text-slate-700"}>File List</span>
                  </div>
                )}
              </NavLink>
            </li>
            <NavLink
              to="/upload"
              className="no-underline"
            >
              {({ isActive }) => (
                <div className={`py-2 px-4 rounded-lg ${isActive && "bg-green-50"} hover:bg-slate-300 transition-all`}>
                  <span className={isActive ? "font-semibold text-green-700" : "text-slate-700"}>Upload</span>
                </div>
              )}
            </NavLink>
          </ul>
        </nav>
      </header>

      <main className="p-6 flex flex-col gap-8">
        <FileProvider>
          <Outlet />
        </FileProvider>
      </main>
    </>
  );
}

export { Layout };
