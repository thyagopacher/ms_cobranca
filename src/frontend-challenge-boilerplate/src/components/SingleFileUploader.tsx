import { useFileContext } from "@/context";
import { ChangeEvent, useState } from "react";
import { FileActionType } from "@/constants";
import { saveFile } from "@/services/api";
 
const SingleFileUploader = () => {
  const { state: { file }, dispatch } =  useFileContext();

  const handleFileChange = (e: ChangeEvent<HTMLInputElement>) => {
    // Do not use useState to control this file change. Instead, use the FileContext
    if (e.target.files) {

      const fileUpload = e.target.files[0];
      dispatch({ type: FileActionType.SET_UPLOAD_FILE, payload: {
        file: fileUpload
      } });
    } 
    
  };

  const handleUpload = async () => {

    const [swalProps, setSwalProps] = useState({});

    // Do your upload logic here. Remember to use the FileContext
    dispatch({
      type: FileActionType.SET_IS_LOADING,
      payload: { isLoading: true },
    });

    const formData = new FormData();
    if (file == null) {
      return;
    }
    formData.append("arquivo", file);

    saveFile(formData).then((result) => {
        return result.json();
    }).then((res) => {
      alert(res.Msg);
    }).finally(() => {
        dispatch({
          type: FileActionType.SET_IS_LOADING,
          payload: { isLoading: false },
        });
    });
  };

  return (
    <div className = "flex flex-col gap-6">
      <div>
        <label htmlFor="file" className="sr-only">
          Choose a file
        </label>
        <input id="file" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv" onChange={handleFileChange} />
      </div>
      {file && (
        <section>
          <p className="pb-6">File details:</p>
          <ul>
            <li>Name: {file.name}</li>
            <li>Type: {file.type}</li>
            <li>Size: {file.size} bytes</li>
          </ul>
        </section>
      )}

      {file && <button className="rounded-lg bg-green-800 text-white px-4 py-2 border-none font-semibold" onClick={handleUpload}>Upload the file</button>}
    </div>
  );
};

export { SingleFileUploader };
