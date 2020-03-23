package local.autorepair.lab2.core;

import lombok.*;

import javax.persistence.*;
import java.sql.Date;
import java.time.LocalDate;
import java.util.*;

@Data
@Entity
@Table
@EqualsAndHashCode(exclude = "serviceList")
public class Autoservice {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    @Column
    private String name;
    @Column
    private String address;
    @Column
    private String tel;
    @Column
    private String email;
    @Column
    private String description;
    @Column(name = "photo")
    private String photoPath;
    @Column(name = "dateadd")
    private Date dateAdd;

    @ManyToMany(cascade = CascadeType.ALL)
    @JoinTable(name = "service_autoservice",
            joinColumns = @JoinColumn(name = "id_autoservice", referencedColumnName="id"),
            inverseJoinColumns = @JoinColumn(name = "id_service" , referencedColumnName = "id"))
    private List<Service> serviceList = new ArrayList<>();


    @PreUpdate
    @PrePersist
    public void setDefaultValues(){
        if(dateAdd == null)
            dateAdd = Date.valueOf(LocalDate.now());
        if(photoPath == null || photoPath.isEmpty())
            photoPath = "/assets/no-image.png";
    }

}
