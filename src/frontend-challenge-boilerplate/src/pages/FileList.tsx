import { ReactElement } from "react";
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"
import { useFileContext } from "@/context";

function FileList(): ReactElement {

  const { state: { fileList } } = useFileContext();
  
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
            <TableRow>
              <TableCell className="font-medium">INV001</TableCell>
              <TableCell>123</TableCell>
              <TableCell>123@sss</TableCell>
              <TableCell className="text-right">R$25.000,00</TableCell>
              <TableCell className="text-right">11/12/1987</TableCell>
              <TableCell className="text-right">123sf1fs32</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </>
    )
}

export { FileList };
