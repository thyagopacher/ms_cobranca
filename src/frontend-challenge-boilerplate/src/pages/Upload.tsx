import { ReactElement } from "react";
import { SingleFileUploader } from "../components";

function Upload(): ReactElement {
  return (
    <>
      <h1 className="text-2xl font-bold pt-5 text-green-800">Upload</h1>
      <SingleFileUploader />
    </>
  )
}

export { Upload };
