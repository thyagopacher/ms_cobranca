import { ReactElement } from "react";
import { Routes, Route } from "react-router-dom";
import { Layout, NoMatch } from "./components";
import { FileList, Upload } from "./pages";


export function App(): ReactElement {
  return (
    <Routes>
      <Route path="/" element={<Layout />}>
        <Route index element={<FileList />} />
        <Route path="upload" element={<Upload />} />
        <Route path="*" element={<NoMatch />} />
      </Route>
    </Routes>
  );
}
