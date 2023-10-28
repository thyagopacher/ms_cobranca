const endpoint = "http://api.local/";

export const saveFile = async (formData: FormData) => {
  const response: Response = await fetch(`${endpoint}/cobranca/importacao/save-file`, {
    method: "POST",
    body: formData,
  });
  return response;
};

export const listFiles = async (page: number, size: number) => {
  const response: Response = await fetch(
    `${endpoint}/cobranca/processamento/list-cobranca?page=${page}&limite=${size}`,
    {
      method: "GET",
    }
  );
  return response;
};

