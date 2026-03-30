import formatMembersCount from "../utils/format";
import { decodeEscapedText } from "../utils/textDecoder";

export function normalizeMovement(item) {
  const files = Array.isArray(item.get_movement_file)
    ? item.get_movement_file
    : [];
  const imageFiles = files
    .filter((file) => {
      const mediaType = (file.mi_media_type || "").toLowerCase();
      return mediaType === "image" || mediaType === "";
    })
    .map((file) => file.mi_upload_file)
    .filter(Boolean);

  return {
    id: item.movements_id,
    usersId: item.users_id,
    status: item.status || "Active",
    leaderName: item.users_name || "Unknown",
    leaderImg: item.users_profile_image || "",
    movementTitle: decodeEscapedText(item.movement_name) || "Untitled movement",
    movementImg: imageFiles[0] || "",
    movementImages: imageFiles,
    members: formatMembersCount(item.total_members),
    description: decodeEscapedText(item.description),
    isJoined: (item.join_status || "").toLowerCase() === "active",
  };
}
