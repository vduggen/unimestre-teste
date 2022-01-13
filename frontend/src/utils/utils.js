export function unformatStr(str) {
  if (str) {
    return str.replace(/[^0-9]/g, "");
  }
}

export function unformatDate(str) {
  if (str) {
    const [date, month, year] = str.split(/[^0-9]/g);

    return `${year}-${month}-${date}`;
  }
}

export function formatDate(str) {
  if (str) {
    const [date, month, year] = str.split(/[^0-9]/g);

    return `${year}/${month}/${date}`;
  }
}
