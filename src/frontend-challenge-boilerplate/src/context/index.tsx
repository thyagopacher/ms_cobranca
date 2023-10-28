import { createContext, useContext, useReducer } from "react";

import { FileActionType } from "@/constants";
import {
  FileAction,
  FileContextState,
  FileDispatch,
  FileProviderProps,
} from "@/types";

export const FileContextInitialValues: Partial<FileContextState> = {
  file: {} as File,
  isLoading: false,
};

const FileContext = createContext<{
  state: FileContextState;
  dispatch: FileDispatch;
}>({
  state: FileContextInitialValues as FileContextState,
  dispatch: () => {},
});

const FileReducer = (
  state: FileContextState,
  action: FileAction,
): FileContextState => { 
  switch (action.type) {
    case FileActionType.SET_UPLOAD_FILE: {
      // Create the action return
      return { ...state, file: action.payload?.file};
    }
    case FileActionType.SET_FILE_LIST: {
      // Create the action return
      return { ...state, fileList: action.payload?.fileList };
    }
    case FileActionType.SET_IS_LOADING: {
      // Create the action return
      return { ...state, isLoading: action.payload?.isLoading };
    }
    default: {
      throw new Error(`Unhandled action type: ${action.type}`);
    }
  }
};

const FileProvider = ({ children }: FileProviderProps) => {
  const [state, dispatch] = useReducer(
    FileReducer,
    FileContextInitialValues as FileContextState,
  );

  return (
    <FileContext.Provider value={{ state, dispatch }}>
      {children}
    </FileContext.Provider>
  );
};

const useFileContext = () => {
  const context = useContext(FileContext);

  if (context === undefined)
    throw new Error("useFileContext must be used within a FileProvider");

  return context;
};

export { FileProvider, useFileContext };
