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
  

  const listFilesPage = (page?: number, size?: number) => {

    const sizeToSearch = size == undefined ? 10 : size;
    const pageToSearch = page == undefined ? 1 : page;
    dispatch({
      type: FileActionType.SET_IS_LOADING,
      payload: { isLoading: true },
    });
    listFiles(pageToSearch, sizeToSearch)
      .then(async (result) => {
        let json = await result.json();
        const fileListRecept = json.Data;
        console.log(fileListRecept);
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
              <TableHead className="w-[100px]">Nome</TableHead>
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
                <TableCell>{item.governmentId}</TableCell>
                <TableCell>{item.email}</TableCell>
                <TableCell>{item.debtAmount}</TableCell>
                <TableCell>{item.debtDueDate}</TableCell>
                <TableCell>{item.debtId}</TableCell>
              </TableRow>
            ))
            
            }            

          </TableBody>
        </Table>
      </>
    )
}

export { FileListPage };
