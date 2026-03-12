const formatMembersCount = (totalMembers) => {
  const value = Number(totalMembers);

  if (Number.isNaN(value)) {
    return totalMembers || "0";
  }

  return new Intl.NumberFormat("en", {
    notation: value >= 1000 ? "compact" : "standard",
    maximumFractionDigits: 1,
  }).format(value);
};

export default formatMembersCount;
