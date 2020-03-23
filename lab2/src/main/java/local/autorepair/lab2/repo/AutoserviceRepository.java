package local.autorepair.lab2.repo;

import local.autorepair.lab2.core.Autoservice;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import java.util.List;

public interface AutoserviceRepository extends JpaRepository<Autoservice, Long> {
    public List<Autoservice> findAutoservicesByNameContaining(String substringName);
}
