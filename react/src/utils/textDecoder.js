export function decodeEscapedText(value) {
  if (typeof value !== "string" || value.length === 0) {
    return "";
  }

  return value
    .replace(
      /\\u([dD][89AaBb][0-9a-fA-F]{2})\\u([dD][c-fC-f][0-9a-fA-F]{2})/g,
      (_, high, low) => {
        const highPart = parseInt(high, 16);
        const lowPart = parseInt(low, 16);
        const codePoint =
          ((highPart - 0xd800) << 10) + (lowPart - 0xdc00) + 0x10000;
        return String.fromCodePoint(codePoint);
      },
    )
    .replace(/\\u([0-9a-fA-F]{4})/g, (_, hex) =>
      String.fromCharCode(parseInt(hex, 16)),
    )
    .replace(/\\n/g, "\n")
    .replace(/\\r/g, "\r")
    .replace(/\\t/g, "\t")
    .replace(/\\\//g, "/");
}
