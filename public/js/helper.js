export function toNumberString(pt) {
  if (!pt) return '';
  return pt.toString().trim().replace(/\s|R\$|r\$/g, '').replace(/\./g, '').replace(/,/g, '.');
}

export function formatPt(value) {
  if (value === '' || value === null || isNaN(Number(value))) return '';
  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(Number(value));
}

export function initPriceFormatting(ids = []) {
  if (!Array.isArray(ids) || !ids.length) return;

  ids.forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;

    el.addEventListener('focus', () => {
      el.value = toNumberString(el.value);
    });

    el.addEventListener('blur', () => {
      el.value = formatPt(toNumberString(el.value));
    });

    if (el.value) {
      el.value = formatPt(toNumberString(el.value));
    }
  });
}
