import { useEffect, useMemo, useState } from "react";
import { useParams } from "react-router-dom";
import { AddMovementSection } from "../../components/movements/addMovement";
import { fetchMovementDetailsAPI } from "../../services/movementService";

const EditMovementPage = () => {
    const { movementId } = useParams();
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState("");
    const [prefillData, setPrefillData] = useState(null);

    const normalizedMovementId = useMemo(
        () => (movementId ? String(movementId) : ""),
        [movementId],
    );

    useEffect(() => {
        if (!normalizedMovementId) {
            setError("Movement id is missing.");
            setIsLoading(false);
            return;
        }

        let isMounted = true;

        const loadMovementDetails = async () => {
            setIsLoading(true);
            setError("");

            try {
                const payload = await fetchMovementDetailsAPI(normalizedMovementId);

                if (!isMounted) {
                    return;
                }

                const data = payload?.data || {};
                const info = data.get_movements || {};
                const files = Array.isArray(data.get_movements_file)
                    ? data.get_movements_file
                    : [];

                const coverImage =
                    files.find(
                        (file) =>
                            (file.mi_media_type || "").toLowerCase() ===
                            "image",
                    )?.mi_upload_file || files[0]?.mi_upload_file || "";

                setPrefillData({
                    movementId: info.movements_id || normalizedMovementId,
                    movementName: info.movement_name || "",
                    description: info.description || "",
                    visibility: info.visibility || "Public",
                    coverImage,
                });
            } catch (err) {
                if (!isMounted) {
                    return;
                }

                setError(err?.message || "Failed to load movement details.");
            } finally {
                if (isMounted) {
                    setIsLoading(false);
                }
            }
        };

        loadMovementDetails();

        return () => {
            isMounted = false;
        };
    }, [normalizedMovementId]);

    return (
        <AddMovementSection
            mode="edit"
            initialData={prefillData}
            isPrefillLoading={isLoading}
            prefillError={error}
        />
    );
};

export default EditMovementPage;
