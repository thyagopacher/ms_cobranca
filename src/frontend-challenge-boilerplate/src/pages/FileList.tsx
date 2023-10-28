import { ReactElement, useEffect } from "react";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";
import { FileActionType } from "@/constants";
import { useFileContext } from "@/context";
import { listFiles } from "@/services/api";

function FileListPage(): ReactElement {

  const { state: { fileList }, dispatch } = useFileContext();
  

  const listFilesPage = (page?: number, limit?: number) => {

    const limitSearch = limit == undefined ? 10 : limit;
    const pageSearch = page == undefined ? 1 : page;
    dispatch({
      type: FileActionType.SET_IS_LOADING,
      payload: { isLoading: true },
    });
    listFiles(pageSearch, limitSearch)
      .then(async (result) => {
        let json = await result.json();
        let resultJson = json.Data;

        const fileListRecept = resultJson;
        fileListRecept.page = parseInt(json.page);
        // console.log(fileListRecept);

        result.ok &&
          dispatch({
            type: FileActionType.SET_FILE_LIST,
            payload: { fileList: fileListRecept },
          });
      })
      .finally(() => {
        dispatch({
          type: FileActionType.SET_IS_LOADING,
          payload: { isLoading: false },
        });
      });
  };

  useEffect(() => {
    listFilesPage();
  }, []);


  // Remember to keep the fileList updated after upload a new file
  /**
   *  Colunas planilha - teste - 'name', 'governmentId', 'email', 'debtAmount', 'debtDueDate', 'debtId', 
   */
    return (
      <>
        <h1 className="text-2xl font-bold pt-5 text-green-800">File List</h1>

        <Table>
          <TableCaption>Listagem de dívidas.</TableCaption>
          <TableHeader>
            <TableRow>
              <TableHead className="w-[200px]">Nome</TableHead>
              <TableHead className="text-right">Número do documento</TableHead>
              <TableHead className="text-center">E-mail Sacado</TableHead>
              <TableHead className="text-right">Valor</TableHead>
              <TableHead className="text-right">Data para Pgto.</TableHead>
              <TableHead className="text-right">UUID Débito</TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            {
            
            fileList != undefined && fileList.map((item, index) => (
            <TableRow key={index}>
                <TableCell>{item.name}</TableCell>
                <TableCell className="text-right">{item.governmentId}</TableCell>
                <TableCell className="text-center">{item.email}</TableCell>
                <TableCell className="text-right">{item.debtAmount}</TableCell>
                <TableCell className="text-right">{item.debtDueDate}</TableCell>
                <TableCell className="text-right">{item.debtId}</TableCell>
              </TableRow>
            ))
            
            }            

          </TableBody>
        </Table>

        {fileList! && (
            <div className="text-center">
              <button
                className="py-2 px-4 btnPagination"
                onClick={() => listFilesPage(fileList.page - 1)}
              >
                Anterior
              </button>

              <button
                className="py-2 px-4 btnPagination"
                onClick={() => listFilesPage(fileList.page + 1)}
              >
                Próximo
              </button>
            </div>
          )}
      </>
    )
}

export { FileListPage };
